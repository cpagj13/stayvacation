<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of all reviews
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Review::with(['user', 'room', 'booking']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $reviews = $query->latest()->paginate(20);
        
        return view('admin.reviews.index', compact('reviews', 'status'));
    }

    /**
     * Approve a review
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Review approved successfully!');
    }

    /**
     * Reject a review
     */
    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->update([
            'status' => 'rejected',
        ]);

        return redirect()->back()->with('success', 'Review rejected.');
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
