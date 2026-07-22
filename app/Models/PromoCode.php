<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_booking_amount',
        'max_uses',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'description',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get bookings that used this promo code
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if promo code is valid
     */
    public function isValid($bookingAmount = null)
    {
        // Check if active
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'This promo code is not active.'];
        }

        // Check if max uses reached
        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return ['valid' => false, 'message' => 'This promo code has reached its maximum uses.'];
        }

        // Check valid from date
        if ($this->valid_from && Carbon::now()->lt($this->valid_from)) {
            return ['valid' => false, 'message' => 'This promo code is not yet valid.'];
        }

        // Check valid until date
        if ($this->valid_until && Carbon::now()->gt($this->valid_until)) {
            return ['valid' => false, 'message' => 'This promo code has expired.'];
        }

        // Check minimum booking amount
        if ($bookingAmount && $this->min_booking_amount && $bookingAmount < $this->min_booking_amount) {
            return ['valid' => false, 'message' => 'Minimum booking amount of ₱' . number_format($this->min_booking_amount, 2) . ' required.'];
        }

        return ['valid' => true, 'message' => 'Promo code is valid!'];
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($bookingAmount)
    {
        if ($this->type === 'percentage') {
            return ($bookingAmount * $this->value) / 100;
        }
        
        return min($this->value, $bookingAmount); // Fixed amount, but not more than booking amount
    }

    /**
     * Increment used count
     */
    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}
