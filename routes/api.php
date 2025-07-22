<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\AdminController;

// Public Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/token', [AuthController::class, 'issueToken']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected Routes using JWT
Route::middleware(['jwt.verify'])->group(function () {
    // User Profile
    Route::get('/user/profile', [AuthController::class, 'profile']);
    Route::post('/user/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/user/logout', [AuthController::class, 'logout']);

    // Wallet Summary + Transactions
    Route::prefix('wallet')->group(function () {
        Route::get('/summary', [WalletController::class, 'getWalletSummary']);
        Route::get('/transactions', [WalletController::class, 'getTransactions']);
        Route::post('/withdraw', [WalletController::class, 'withdraw']);
        Route::get('/withdrawals', [WalletController::class, 'withdrawals']);
    });

    // Store APIs
    Route::get('/stores', [StoreController::class, 'list']);
    Route::get('/stores/{id}', [StoreController::class, 'detail']);
    Route::get('/stores/{id}/track', [StoreController::class, 'trackStoreClick']);

    // Order APIs
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // Support/Help Center
    Route::prefix('support')->group(function () {
        Route::post('/tickets', [SupportController::class, 'createTicket']);
        Route::get('/tickets', [SupportController::class, 'listTickets']);
        Route::get('/tickets/{id}', [SupportController::class, 'showTicket']);
    });
});

// Affiliate Callback Routes (Public, with secret/IP validation)
Route::prefix('callback')->group(function () {
    Route::post('/cuelinks', [CallbackController::class, 'handleCuelinks'])->middleware('callback.validate');
    Route::get('/callback', [CallbackController::class, 'handle']);
});

// Admin Panel Routes (Deferred for later)
Route::middleware(['jwt.verify', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('stores', AdminController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::put('/orders/{id}/review', [AdminController::class, 'reviewOrder']);
    Route::get('/users', [AdminController::class, 'listUsers']);
    Route::get('/users/{id}', [AdminController::class, 'showUser']);
    Route::put('/wallet/withdrawals/{id}/review', [WalletController::class, 'reviewWithdrawal']);
});

?>