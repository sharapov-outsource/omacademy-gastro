<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Routes accessible to all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Booking routes (existing functionality)
    Route::post('/bookings', [HomeController::class, 'storeBooking'])->name('bookings.store');

    // Menu management routes
    Route::post('/menu', [HomeController::class, 'storeMenu'])->name('menu.store'); // Add a new dish
    Route::patch('/menu', [HomeController::class, 'updateMenu'])->name('menu.update'); // Update menu dishes
    Route::delete('/menu/{id}', [HomeController::class, 'destroyMenu'])->name('menu.destroy'); // Delete a dish
});

// Admin-only routes with middleware protection
Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('bookings.index'); // Admin dashboard
    Route::patch('/admin/status', [AdminController::class, 'updateStatus'])->name('bookings.updateStatus'); // Update booking status
});
