<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review
     */
    public function create($bookingId)
    {
        $booking = Booking::with('room')->findOrFail($bookingId);
        
        // Check if user owns this booking
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Check if already reviewed
        if ($booking->hasReview()) {
            return redirect()->route('profile.edit')->with('error', 'You have already reviewed this booking.');
        }
        
        // Check if booking is completed
        if ($booking->status !== 'confirmed' && $booking->status !== 'completed') {
            return redirect()->route('profile.edit')->with('error', 'You can only review confirmed or completed bookings.');
        }
        
        return view('reviews.create', compact('booking'));
    }

    /**
     * Store a newly created review in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);
        
        // Check ownership
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Check if already reviewed
        if ($booking->hasReview()) {
            return redirect()->route('profile.edit')->with('error', 'You have already reviewed this booking.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'room_id' => $booking->room_id,
            'booking_id' => $booking->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'pending', // Admin must approve
        ]);

        return redirect()->route('profile.edit')->with('success', 'Review submitted! It will be visible after admin approval.');
    }

    /**
     * Display reviews for a specific room
     */
    public function roomReviews($roomId)
    {
        $reviews = Review::where('room_id', $roomId)
            ->where('status', 'approved')
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('reviews.list', compact('reviews'));
    }
}
