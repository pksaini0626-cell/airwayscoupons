<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\ManageAirlines;
use App\Livewire\Admin\ManageCoupons;
use App\Livewire\Admin\ManageSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/track-click/{id}', [HomeController::class, 'trackClick'])->name('coupon.track');

// Admin Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', Login::class)->name('admin.login');
});

// Admin Logout
Route::post('/admin/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('logout');

// Admin Protected Routes
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/coupons', ManageCoupons::class)->name('admin.coupons');
    Route::get('/airlines', ManageAirlines::class)->name('admin.airlines');
    Route::get('/settings', ManageSettings::class)->name('admin.settings');
});
