<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\SupportController;

Route::prefix('auth')->group(function () {
    Route::post('send-otp', [AuthController::class, 'sendOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/update-info', [AuthController::class, 'updatePersonalInfo']);
    Route::get('user/profile', [AuthController::class, 'profile']);
    Route::put('user/profile', [AuthController::class, 'updateProfile']);
    Route::get('stores', [StoreController::class, 'index']);
    Route::get('stores/{id}', [StoreController::class, 'show']);
    Route::post('stores/{id}/track', [StoreController::class, 'trackStoreClick']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::get('wallet/balance', [WalletController::class, 'balance']);
    Route::get('wallet/transactions', [WalletController::class, 'transactions']);
    Route::post('wallet/withdrawal', [WalletController::class, 'requestWithdrawal']);
    Route::post('support/tickets', [SupportController::class, 'createTicket']);
    Route::get('support/tickets', [SupportController::class, 'index']);
    Route::get('support/tickets/{id}', [SupportController::class, 'show']);
    Route::put('support/tickets/{id}/close', [SupportController::class, 'closeTicket']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
});

Route::post('callback/cuelinks', [CallbackController::class, 'handleCuelinksCallback'])->middleware('callback.validate');