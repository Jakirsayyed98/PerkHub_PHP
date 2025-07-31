<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\AffiliateProviderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\NotificationController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('stores', StoreController::class)->only(['index', 'create', 'edit']);
    Route::resource('affiliates', AffiliateProviderController::class)->only(['index', 'create', 'edit']);
    Route::resource('users', UserController::class)->only(['index', 'show']);
    Route::resource('withdrawals', WithdrawalController::class)->only(['index']);
    Route::resource('tickets', SupportTicketController::class)->only(['index', 'edit']);
    Route::resource('notifications', NotificationController::class)->only(['index', 'create']);
});
});