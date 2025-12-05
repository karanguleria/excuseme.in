<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SuperAdmin\RestaurantController;
use App\Http\Controllers\ProfileController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest routes (no auth required)
Route::get('/table/{uniqueUrl}', [GuestController::class, 'show'])->name('guest.show');
Route::post('/table/{uniqueUrl}/ring', [GuestController::class, 'ring'])->name('guest.ring');
Route::post('/table/{uniqueUrl}/stop', [GuestController::class, 'stopRing'])->name('guest.stop');
Route::get('/table/{uniqueUrl}/status', [GuestController::class, 'checkStatus'])->name('guest.status');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/tables', [DashboardController::class, 'getTables'])->name('api.tables');
    Route::post('/api/tables/{table}/acknowledge', [DashboardController::class, 'acknowledgeCall'])->name('api.tables.acknowledge');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Super Admin routes
    Route::prefix('super-admin')->name('super-admin.')->middleware('can:super-admin')->group(function () {
        Route::resource('restaurants', RestaurantController::class);
    });
});
