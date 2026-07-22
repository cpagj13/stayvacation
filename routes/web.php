<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\AnalyticsController;

Route::get('/', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    $rooms = \App\Models\Room::all();
    return view('welcome', compact('rooms'));
})->name('home');

Route::get('/rooms', function (Request $request) {
    $query = \App\Models\Room::with('category');
    
    // Search by name
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    
    // Filter by category
    if ($request->filled('category')) {
        $query->where('room_category_id', $request->category);
    }
    
    // Filter by price range
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }
    
    // Filter by capacity
    if ($request->filled('capacity')) {
        $query->where('capacity', '>=', $request->capacity);
    }
    
    // Sort
    $sort = $request->get('sort', 'name_asc');
    switch ($sort) {
        case 'price_asc':
            $query->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('price', 'desc');
            break;
        case 'capacity_desc':
            $query->orderBy('capacity', 'desc');
            break;
        default:
            $query->orderBy('name', 'asc');
    }
    
    $rooms = $query->get();
    $categories = \App\Models\RoomCategory::withCount('rooms')->get();
    
    return view('rooms.index', compact('rooms', 'categories'));
})->name('rooms.index');

// Room Details Page
Route::get('/rooms/{room}', function (\App\Models\Room $room) {
    $room->load('category', 'bookings');
    $relatedRooms = \App\Models\Room::where('id', '!=', $room->id)
        ->where('room_category_id', $room->room_category_id)
        ->limit(3)
        ->get();
    
    return view('rooms.show', compact('room', 'relatedRooms'));
})->name('rooms.show');

Route::get('/book-now', function () {
    if (auth()->check()) {
        return redirect()->route('booking.step1');
    }
    session(['url.intended' => route('booking.step1')]);
    return redirect()->route('register');
})->name('book-now');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/calendar', [DashboardController::class, 'calendar'])->name('calendar');
    Route::get('/bookings/{booking}/edit', [DashboardController::class, 'editBooking'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [DashboardController::class, 'updateBooking'])->name('bookings.update');
    Route::patch('/bookings/{booking}/status', [DashboardController::class, 'updateStatus'])->name('bookings.status');
    Route::patch('/bookings/{booking}/cancel', [DashboardController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::delete('/bookings/{booking}', [DashboardController::class, 'deleteBooking'])->name('bookings.delete');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    
    // Reviews Management
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Promo Codes Management
    Route::resource('promo-codes', PromoCodeController::class);
    Route::get('/promo-codes-export', [PromoCodeController::class, 'export'])->name('promo-codes.export');
    
    // Analytics & Reports
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export-bookings', [AnalyticsController::class, 'exportBookings'])->name('analytics.export-bookings');
    Route::get('/analytics/export-revenue', [AnalyticsController::class, 'exportRevenue'])->name('analytics.export-revenue');
});

Route::get('/book-now', function () {
    if (auth()->check()) {
        return redirect()->route('booking.step1');
    }

    session(['url.intended' => route('booking.step1')]);
    return redirect()->route('register');
})->name('book-now');

use App\Http\Controllers\Auth\OtpController;

Route::get('/verify-otp', [OtpController::class, 'showVerify'])->name('otp.verify');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify.submit');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bookings list
    Route::get('/bookings', function () {
        $bookings = auth()->user()->bookings()->with('room.category')->latest()->get();
        return view('bookings.index', compact('bookings'));
    })->name('bookings.index');

    // Booking wizard
    Route::get('/booking/step1', [BookingController::class, 'step1'])->name('booking.step1');
    Route::post('/booking/step1', [BookingController::class, 'storeStep1'])->name('booking.step1.store');
    Route::get('/booking/room-bookings/{room}', [BookingController::class, 'roomBookedDates'])->name('booking.room-bookings');
    Route::post('/booking/apply-promo', [BookingController::class, 'applyPromo'])->name('booking.apply-promo');
    Route::get('/booking/step2', [BookingController::class, 'step2'])->name('booking.step2');
    Route::post('/booking/step2', [BookingController::class, 'storeStep2'])->name('booking.step2.store');

    Route::get('/booking/step3', [BookingController::class, 'step3'])->name('booking.step3');
    Route::get('/booking/proof/{path}', [BookingController::class, 'showProof'])->name('booking.proof')->where('path', '.*');
    Route::post('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');

    Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');
    
    // Reviews
    Route::get('/reviews/create/{booking}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';

// Contact Page
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// Legal Pages
Route::get('/terms', function () {
    return view('legal.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('privacy');

Route::get('/cancellation-policy', function () {
    return view('legal.cancellation');
})->name('cancellation');

Route::get('/refund-policy', function () {
    return view('legal.refund');
})->name('refund');