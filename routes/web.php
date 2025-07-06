<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/admin', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/admin/export', [DashboardController::class, 'export'])->middleware('auth');

Route::get('/', function () {
    return view('home');
});

Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/get-price', [BookingController::class, 'getPrice']);
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
