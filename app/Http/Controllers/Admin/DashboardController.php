<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'total_users' => User::count(),
        ];

        $bookings = Booking::with(['user', 'room'])->latest()->paginate(15);

        return view('admin.dashboard', compact('stats', 'bookings'));
    }

    public function calendar()
    {
        $bookings = Booking::with(['room.category', 'user'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $events = $bookings->map(fn ($booking) => [
            'id'       => $booking->id,
            'guest'    => $booking->guest_name,
            'email'    => $booking->user->email ?? '—',
            'room'     => $booking->room->name ?? '—',
            'category' => $booking->room->category->name ?? 'Standard',
            'from'     => $booking->check_in->format('Y-m-d'),
            'to'       => $booking->check_out->format('Y-m-d'),
            'fromFormatted' => $booking->check_in->format('M d, Y'),
            'toFormatted'   => $booking->check_out->format('M d, Y'),
            'nights'   => $booking->check_in->diffInDays($booking->check_out),
            'guests'   => $booking->guests,
            'rooms_count' => $booking->rooms_count,
            'total'    => number_format($booking->total_price, 2),
            'status'   => $booking->status,
            'proof'    => $booking->proof_path ? route('booking.proof', ['path' => $booking->proof_path]) : null,
        ]);

        return view('admin.calendar', compact('events'));
    }

    public function updateStatus(Booking $booking, \Illuminate\Http\Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated.');
    }

    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking has been cancelled.');
    }

    public function deleteBooking(Booking $booking)
    {
        $booking->delete();

        return back()->with('success', 'Booking has been deleted permanently.');
    }

    public function editBooking(Booking $booking)
    {
        $booking->load(['user', 'room.category']);
        $rooms = \App\Models\Room::with('category')->get();
        
        return view('admin.bookings.edit', compact('booking', 'rooms'));
    }

    public function updateBooking(\Illuminate\Http\Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'rooms_count' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        // Calculate total price
        $room = \App\Models\Room::findOrFail($validated['room_id']);
        $checkIn = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out']);
        $nights = $checkIn->diffInDays($checkOut);
        $validated['total_price'] = $room->price * $nights * $validated['rooms_count'];

        $booking->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Booking updated successfully.');
    }
}