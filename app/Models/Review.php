<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'booking_id',
        'rating',
        'comment',
        'status',
        'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user that wrote the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room being reviewed
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the booking associated with this review
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Scope to only get approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to only get pending reviews
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
