<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['room_category_id', 'name', 'type', 'price', 'capacity', 'image', 'description', 'amenities'];

    protected $casts = [
        'amenities' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function category()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->hasOne(RoomImage::class)->where('is_primary', true);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    /**
     * Get average rating for this room
     */
    public function averageRating()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
     * Get total number of reviews for this room
     */
    public function reviewsCount()
    {
        return $this->approvedReviews()->count();
    }
}