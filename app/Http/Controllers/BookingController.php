<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // STEP 1: guest name, check-in/out, room + price
    public function step1()
    {
        $rooms = Room::all();
        return view('booking.step1', compact('rooms'));
    }
    public function roomBookedDates(Room $room)
    {
        $ranges = $room->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['check_in', 'check_out', 'status'])
            ->map(fn ($booking) => [
                'from'   => $booking->check_in->format('Y-m-d'),
                'to'     => $booking->check_out->format('Y-m-d'),
                'status' => $booking->status,
            ]);

        return response()->json($ranges);
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'guest_name'     => 'required|string|max:255',
            'check_in'       => 'required|date|after_or_equal:today',
            'check_out'      => 'required|date|after:check_in',
            'room_id'        => 'required|exists:rooms,id',
            'guests'         => 'required|integer|min:1|max:12',
            'rooms_count'    => 'required|integer|min:1|max:20',
            'payment_method' => 'required|string|in:gcash,maya,bank_transfer,card,cash',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if ($validated['guests'] > $room->capacity * $validated['rooms_count']) {
            return back()->withErrors([
                'guests' => "This room sleeps up to {$room->capacity} guests per room. Increase the number of rooms or reduce guests.",
            ])->withInput();
        }

        $checkIn = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out']);

        $hasOverlap = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $checkOut->toDateString())
            ->where('check_out', '>', $checkIn->toDateString())
            ->exists();

        if ($hasOverlap) {
            return back()->withErrors([
                'check_in' => 'The selected dates overlap with an existing booking for this room.',
                'check_out' => 'The selected dates overlap with an existing booking for this room.',
            ])->withInput();
        }

        $nights = $checkIn->diffInDays($checkOut);
        $nights = max($nights, 1);

        $originalPrice = $room->price * $nights * $validated['rooms_count'];
        $promoCodeStr = $request->input('promo_code');
        $promoCodeId = null;
        $discountAmount = 0;

        if ($promoCodeStr) {
            $promo = \App\Models\PromoCode::where('code', strtoupper(trim($promoCodeStr)))->first();
            if ($promo && $promo->isValid($originalPrice)['valid']) {
                $promoCodeId = $promo->id;
                $discountAmount = $promo->calculateDiscount($originalPrice);
            }
        }

        $finalPrice = max(0, $originalPrice - $discountAmount);

        session([
            'booking.step1' => [
                'guest_name'      => $validated['guest_name'],
                'guests'          => $validated['guests'],
                'check_in'        => $validated['check_in'],
                'check_out'       => $validated['check_out'],
                'room_id'         => $room->id,
                'room_name'       => $room->name,
                'rooms_count'     => $validated['rooms_count'],
                'payment_method'  => $validated['payment_method'],
                'promo_code'      => $promoCodeStr,
                'promo_code_id'   => $promoCodeId,
                'discount_amount' => $discountAmount,
                'price_per_night' => $room->price,
                'original_price'  => $originalPrice,
                'total_price'     => $finalPrice,
                'nights'          => $nights,
            ],
        ]);

        return redirect()->route('booking.step2');
    }

    // STEP 2: upload transaction proof (pdf, png, jpg, jpeg)
    public function step2()
    {
        if (!session()->has('booking.step1')) {
            return redirect()->route('booking.step1')
                ->with('error', 'Please complete step 1 first.');
        }

        $step1 = session('booking.step1');
        return view('booking.step2', compact('step1'));
    }

    public function storeStep2(Request $request)
    {
        $file = $this->validateProofFile($request);
        $path = $file->store('proofs', 'public');

        session(['booking.step2' => ['proof_path' => $path]]);

        return redirect()->route('booking.step3');
    }

    protected function validateProofFile(Request $request)
    {
        // First check if raw file was submitted via HTTP form
        $rawFile = $request->files->get('proof');

        if ($rawFile && !$rawFile->isValid()) {
            $errorCode = $rawFile->getError();
            if ($errorCode === UPLOAD_ERR_INI_SIZE || $errorCode === UPLOAD_ERR_FORM_SIZE) {
                $maxIniSize = ini_get('upload_max_filesize');
                throw ValidationException::withMessages([
                    'proof' => ["The uploaded file exceeds the server's maximum upload limit ({$maxIniSize}). Please select a smaller file."],
                ]);
            }
            if ($errorCode !== UPLOAD_ERR_NO_FILE) {
                throw ValidationException::withMessages([
                    'proof' => ['File upload error: ' . $rawFile->getErrorMessage()],
                ]);
            }
        }

        if (!$request->hasFile('proof')) {
            throw ValidationException::withMessages([
                'proof' => ['Please select a payment proof file to upload.'],
            ]);
        }

        $file = $request->file('proof');

        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages([
                'proof' => ['The proof file failed to upload properly. Please try again.'],
            ]);
        }

        $allowedExtensions = ['pdf', 'png', 'jpg', 'jpeg', 'webp'];
        $allowedMimeTypes = [
            'application/pdf',
            'image/png',
            'image/jpeg',
            'image/jpg',
            'image/pjpeg',
            'image/x-png',
            'image/webp',
        ];

        $extension = strtolower($file->getClientOriginalExtension());
        $guessExtension = strtolower((string) $file->guessExtension());
        $mimeType = strtolower((string) $file->getClientMimeType());

        $hasAllowedExtension = in_array($extension, $allowedExtensions, true) || in_array($guessExtension, $allowedExtensions, true);
        $hasAllowedMimeType = in_array($mimeType, $allowedMimeTypes, true);

        if (!$hasAllowedExtension && !$hasAllowedMimeType) {
            throw ValidationException::withMessages([
                'proof' => ['The proof must be a PDF, PNG, JPG, or JPEG file.'],
            ]);
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'proof' => ['The proof file size may not be larger than 5MB.'],
            ]);
        }

        return $file;
    }

    // STEP 3: summary & confirmation
    public function step3()
    {
        if (!session()->has('booking.step1') || !session()->has('booking.step2')) {
            return redirect()->route('booking.step1')
                ->with('error', 'Please complete the previous steps first.');
        }

        $data = array_merge(session('booking.step1'), session('booking.step2'));
        return view('booking.step3', compact('data'));
    }

    // Confirm -> save to DB + send email (this triggers "Step 4")
    public function confirm(Request $request)
    {
        if (!session()->has('booking.step1') || !session()->has('booking.step2')) {
            return redirect()->route('booking.step1');
        }

        $step1 = session('booking.step1');
        $step2 = session('booking.step2');

        $booking = Booking::create([
            'user_id'         => Auth::id(),
            'room_id'         => $step1['room_id'],
            'guest_name'      => $step1['guest_name'],
            'guests'          => $step1['guests'],
            'check_in'        => $step1['check_in'],
            'check_out'       => $step1['check_out'],
            'rooms_count'     => $step1['rooms_count'],
            'total_price'     => $step1['total_price'],
            'payment_method'  => $step1['payment_method'] ?? 'gcash',
            'promo_code_id'   => $step1['promo_code_id'] ?? null,
            'discount_amount' => $step1['discount_amount'] ?? 0,
            'proof_path'      => $step2['proof_path'],
            'status'          => 'pending',
        ]);

        if (!empty($step1['promo_code_id'])) {
            $promo = \App\Models\PromoCode::find($step1['promo_code_id']);
            if ($promo) {
                $promo->incrementUsage();
            }
        }

        // STEP 4: send booking details to the user's Gmail
        Mail::to(Auth::user()->email)->send(new BookingConfirmationMail($booking));

        session()->forget(['booking.step1', 'booking.step2']);
        session(['booking.last_id' => $booking->id]);

        return redirect()->route('booking.success');
    }

    public function success()
    {
        $booking = Booking::with('room')->findOrFail(session('booking.last_id'));
        return view('booking.success', compact('booking'));
    }

    public function showProof(string $path)
    {
        if (!Auth::check()) {
            abort(403);
        }

        if (!str_starts_with($path, 'proofs/')) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($path);

        if (!Storage::disk('public')->exists($path) || !is_file($fullPath)) {
            abort(404);
        }

        return response()->file($fullPath, [
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    public function applyPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string',
            'amount'     => 'nullable|numeric|min:0',
        ]);

        $code = strtoupper(trim($request->promo_code));
        $promo = \App\Models\PromoCode::where('code', $code)->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid promo code.',
            ], 422);
        }

        $bookingAmount = floatval($request->amount ?? 0);
        $validation = $promo->isValid($bookingAmount);

        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $validation['message'],
            ], 422);
        }

        $discount = $promo->calculateDiscount($bookingAmount);
        $finalTotal = max(0, $bookingAmount - $discount);

        return response()->json([
            'success'         => true,
            'message'         => 'Promo code applied successfully!',
            'code'            => $promo->code,
            'promo_id'        => $promo->id,
            'type'            => $promo->type,
            'value'           => floatval($promo->value),
            'discount_amount' => round($discount, 2),
            'final_total'     => round($finalTotal, 2),
        ]);
    }
}