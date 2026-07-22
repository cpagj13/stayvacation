<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::latest()->paginate(15);
        return view('admin.promo-codes.index', compact('promoCodes'));
    }

    public function create()
    {
        return view('admin.promo-codes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes|max:50|alpha_dash',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_booking_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->has('is_active');

        PromoCode::create($validated);

        return redirect()->route('admin.promo-codes.index')->with('success', 'Promo code created successfully!');
    }

    public function edit(PromoCode $promoCode)
    {
        return view('admin.promo-codes.edit', compact('promoCode'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|alpha_dash|unique:promo_codes,code,' . $promoCode->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_booking_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->has('is_active');

        $promoCode->update($validated);

        return redirect()->route('admin.promo-codes.index')->with('success', 'Promo code updated successfully!');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return redirect()->route('admin.promo-codes.index')->with('success', 'Promo code deleted successfully!');
    }

    /**
     * Export promo codes to CSV
     */
    public function export()
    {
        $promoCodes = PromoCode::all();
        
        $filename = 'promo-codes-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($promoCodes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Code', 'Type', 'Value', 'Min Amount', 'Max Uses', 'Used Count', 'Valid From', 'Valid Until', 'Active', 'Description']);

            foreach ($promoCodes as $code) {
                fputcsv($file, [
                    $code->code,
                    $code->type,
                    $code->value,
                    $code->min_booking_amount ?? 'N/A',
                    $code->max_uses ?? 'Unlimited',
                    $code->used_count,
                    $code->valid_from ? $code->valid_from->format('Y-m-d') : 'N/A',
                    $code->valid_until ? $code->valid_until->format('Y-m-d') : 'N/A',
                    $code->is_active ? 'Yes' : 'No',
                    $code->description ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
