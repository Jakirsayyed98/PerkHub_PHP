<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NotificationController;

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
});

Route::prefix('api')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);
});

Route::prefix('auth')->group(function () {
    Route::post('send-otp', [AuthController::class, 'sendOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/update-info', [AuthController::class, 'updatePersonalInfo']);
    Route::get('user/profile', [UserController::class, 'showUser']);
    Route::put('user/profile', [UserController::class, 'updateProfile']);
    Route::get('stores', [StoreController::class, 'index']);
    Route::get('stores/{id}', [StoreController::class, 'show']);
    Route::post('stores/{id}/track', [StoreController::class, 'trackStoreClick']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::get('wallet/summary', [WalletController::class, 'getWalletSummary']);
    Route::get('wallet/transactions', [WalletController::class, 'transactions']);
    Route::post('wallet/withdrawal', [WalletController::class, 'withdraw']);
    Route::get('wallet/withdrawals', [WalletController::class, 'withdrawals']);
    Route::post('support/tickets', [SupportController::class, 'createTicket']);
    Route::get('support/tickets', [SupportController::class, 'index']);
    Route::get('support/tickets/{id}', [SupportController::class, 'show']);
    Route::put('support/tickets/{id}/close', [SupportController::class, 'closeTicket']);
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('notifications/{id}', [NotificationController::class, 'show']);
    Route::put('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::post('notifications/fcm-token', [NotificationController::class, 'storeFcmToken']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
});

Route::post('callback/cuelinks', [CallbackController::class, 'handleCuelinks'])->middleware('callback.validate');