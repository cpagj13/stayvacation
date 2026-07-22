<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Support\Facades\Route;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{room}', [RoomController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

// Authenticated (any logged-in user)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    Route::post('/bookings', [BookingController::class, 'store']);
});

// Admin-only
// Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/bookings', [AdminBookingController::class, 'index']);
//     Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus']);
//     Route::apiResource('categories', AdminCategoryController::class)->except(['show']);
//     Route::apiResource('products', AdminProductController::class)->except(['show']);
// });