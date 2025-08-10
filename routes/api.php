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
    Route::get('/dashboard', function () {
        return response()->json([
            'status' => true,
            'data' => [
                'store_count' => 0,
                'affiliate_count' => 0,
                'user_count' => 0,
                'transaction_count' => 0,
                'withdrawal_request_count' => 0
            ]
        ]);
    })->middleware('auth:sanctum');
});

Route::prefix('api')->group(function () {
    Route::prefix('admin')->middleware('auth:api')->group(function () {
        Route::get('/tickets', [SupportTicketController::class, 'apiIndex']);
    });
});

Route::prefix('api')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);
});

Route::prefix('auth')->group(function () {
    Route::post('send-otp', [ApiAuthController::class, 'sendOtp']);
    Route::post('verify-otp', [ApiAuthController::class, 'verifyOtp']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/update-info', [ApiAuthController::class, 'updatePersonalInfo']);
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
    // Route::post('tickets', [TicketController::class, 'createTicket'])->name('api.ticket.create');
    // Route::get('tickets', [TicketController::class, 'getUserTickets'])->name('api.ticket.list');
    // Route::get('tickets/{id}', [TicketController::class, 'getUserTicketById'])->name('api.ticket.show');
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('notifications/{id}', [NotificationController::class, 'show']);
    Route::put('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::post('notifications/fcm-token', [NotificationController::class, 'storeFcmToken']);
    Route::post('auth/logout', [ApiAuthController::class, 'logout']);
    Route::post('auth/refresh', [ApiAuthController::class, 'refresh']);
});

Route::post('callback/cuelinks', [CallbackController::class, 'handleCuelinks'])->middleware('callback.validate');