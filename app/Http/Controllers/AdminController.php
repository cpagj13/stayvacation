<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'total_users' => User::count(),
        ];

        $bookings = Booking::with(['user', 'room'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'bookings'));
    }
}