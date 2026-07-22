<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // days
        $startDate = Carbon::now()->subDays($period);

        // Revenue Statistics
        $totalRevenue = Booking::where('status', 'confirmed')
            ->sum('total_price');
        
        $revenueThisPeriod = Booking::where('status', 'confirmed')
            ->where('created_at', '>=', $startDate)
            ->sum('total_price');

        // Booking Statistics
        $totalBookings = Booking::count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        // Occupancy Rate
        $totalRooms = Room::count();
        $bookedRoomsCount = Booking::where('status', 'confirmed')
            ->where('check_in', '<=', Carbon::now())
            ->where('check_out', '>=', Carbon::now())
            ->distinct('room_id')
            ->count('room_id');
        $occupancyRate = $totalRooms > 0 ? ($bookedRoomsCount / $totalRooms) * 100 : 0;

        // Popular Rooms
        $popularRooms = Room::withCount(['bookings' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        // Revenue by Month (last 6 months)
        $monthlyRevenue = Booking::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as bookings')
            )
            ->where('status', 'confirmed')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Bookings by Status
        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Customer Statistics
        $totalCustomers = User::where('role', '!=', 'admin')->count();
        $newCustomersThisPeriod = User::where('role', '!=', 'admin')
            ->where('created_at', '>=', $startDate)
            ->count();

        // Average Booking Value
        $avgBookingValue = Booking::where('status', 'confirmed')
            ->avg('total_price');

        // Reviews Statistics
        $totalReviews = Review::count();
        $averageRating = Review::where('status', 'approved')->avg('rating');
        $pendingReviews = Review::where('status', 'pending')->count();

        return view('admin.analytics.index', compact(
            'totalRevenue',
            'revenueThisPeriod',
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'cancelledBookings',
            'occupancyRate',
            'popularRooms',
            'monthlyRevenue',
            'bookingsByStatus',
            'totalCustomers',
            'newCustomersThisPeriod',
            'avgBookingValue',
            'totalReviews',
            'averageRating',
            'pendingReviews',
            'period'
        ));
    }

    /**
     * Export bookings report to CSV
     */
    public function exportBookings(Request $request)
    {
        $status = $request->get('status');
        $query = Booking::with(['user', 'room']);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $bookings = $query->get();
        
        $filename = 'bookings-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Guest Name', 'Room', 'Check-in', 'Check-out', 'Guests', 'Total Price', 'Status', 'Booked Date']);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->guest_name,
                    $booking->room->name ?? 'N/A',
                    $booking->check_in->format('Y-m-d'),
                    $booking->check_out->format('Y-m-d'),
                    $booking->guests,
                    $booking->total_price,
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export revenue report to CSV
     */
    public function exportRevenue()
    {
        $bookings = Booking::with(['room', 'promoCode'])
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $filename = 'revenue-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Booking ID', 'Room', 'Guest', 'Total Price', 'Discount', 'Promo Code', 'Net Revenue']);

            $totalRevenue = 0;
            foreach ($bookings as $booking) {
                $netRevenue = $booking->total_price;
                $totalRevenue += $netRevenue;
                
                fputcsv($file, [
                    $booking->created_at->format('Y-m-d'),
                    $booking->id,
                    $booking->room->name ?? 'N/A',
                    $booking->guest_name,
                    $booking->total_price,
                    $booking->discount_amount ?? 0,
                    $booking->promoCode->code ?? 'N/A',
                    $netRevenue,
                ]);
            }

            // Add total row
            fputcsv($file, ['', '', '', '', '', '', 'TOTAL:', $totalRevenue]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
