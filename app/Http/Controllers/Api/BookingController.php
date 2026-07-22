<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->bookings()->with('room')->latest()->get()
        );
    }

    public function show(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        return response()->json($booking->load('room'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'check_in'   => 'required|date|after_or_equal:today',
            'check_out'  => 'required|date|after:check_in',
            'room_id'    => 'required|exists:rooms,id',
        ]);

        $file = $this->validateProofFile($request);

        $room = Room::findOrFail($validated['room_id']);
        $nights = max(
            \Carbon\Carbon::parse($validated['check_in'])->diffInDays(\Carbon\Carbon::parse($validated['check_out'])),
            1
        );

        $path = $file->store('proofs', 'public');

        $booking = Booking::create([
            'user_id'     => $request->user()->id,
            'room_id'     => $room->id,
            'guest_name'  => $validated['guest_name'],
            'check_in'    => $validated['check_in'],
            'check_out'   => $validated['check_out'],
            'total_price' => $room->price * $nights,
            'proof_path'  => $path,
            'status'      => 'pending',
        ]);

        Mail::to($request->user()->email)->send(new BookingConfirmationMail($booking));

        return response()->json($booking->load('room'), 201);
    }

    protected function validateProofFile(Request $request)
    {
        if (!$request->hasFile('proof')) {
            throw ValidationException::withMessages([
                'proof' => ['Please upload a proof file.'],
            ]);
        }

        $file = $request->file('proof');

        if (!$file) {
            throw ValidationException::withMessages([
                'proof' => ['The proof failed to upload.'],
            ]);
        }

        $allowedExtensions = ['pdf', 'png', 'jpg', 'jpeg'];
        $allowedMimeTypes = ['application/pdf', 'image/png', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png'];
        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = strtolower((string) $file->getClientMimeType());
        $hasAllowedExtension = in_array($extension, $allowedExtensions, true);
        $hasAllowedMimeType = in_array($mimeType, $allowedMimeTypes, true);

        if (!$hasAllowedExtension && !$hasAllowedMimeType) {
            throw ValidationException::withMessages([
                'proof' => ['The proof must be a PDF, PNG, JPG, or JPEG file.'],
            ]);
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'proof' => ['The proof may not be larger than 5MB.'],
            ]);
        }

        return $file;
    }
}