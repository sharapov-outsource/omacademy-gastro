<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\WaiterController;
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

    // Menu management routes
    Route::post('/menu', [HomeController::class, 'storeMenu'])->name('menu.store'); // Add a new dish
    Route::patch('/menu', [HomeController::class, 'updateMenu'])->name('menu.update'); // Update menu dishes
    Route::delete('/menu/{id}', [HomeController::class, 'destroyMenu'])->name('menu.destroy'); // Delete a dish

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

});

// Admin-only routes with middleware protection
Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index'); // Admin dashboard
    Route::get('/waiters', [WaiterController::class, 'index'])->name('waiters.index'); // List all waiters
    Route::post('/waiters', [WaiterController::class, 'store'])->name('waiters.store'); // Add a new waiter
    Route::patch('/waiters', [WaiterController::class, 'update'])->name('waiters.update'); // Update waiter info
    Route::delete('/waiters/{id}', [WaiterController::class, 'destroy'])->name('waiters.destroy'); // Delete a waiter

});
