<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;
use App\Models\WithdrawalLog;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Submit a withdrawal request
     */
    public function withdraw(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:upi,bank',
            'account_details' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validation failed',
                $validator->errors(),
                422,
                'VALIDATION_FAILED'
            );
        }

        if ($request->method === 'upi' && !preg_match('/^[\w\.\-]+@[\w\.\-]+$/', $request->account_details)) {
            return ApiResponse::error(
                'Invalid UPI ID format',
                [],
                422,
                'INVALID_UPI_FORMAT'
            );
        }

        if ($request->method === 'bank') {
            $bankValidator = Validator::make($request->all(), [
                'account_details' => 'required|regex:/^[0-9]{9,18}$/', // Basic account number validation
                'ifsc_code' => 'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            ]);

            if ($bankValidator->fails()) {
                return ApiResponse::error(
                    'Invalid bank account details',
                    $bankValidator->errors(),
                    422,
                    'INVALID_BANK_DETAILS'
                );
            }
        }

        $key = 'withdraw:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return ApiResponse::error(
                'You can only request one withdrawal per hour',
                [],
                429,
                'RATE_LIMIT_EXCEEDED'
            );
        }

        if (User::hasPendingWithdrawal($user->id)) {
            return ApiResponse::error(
                'You already have a pending withdrawal request',
                [],
                409,
                'PENDING_WITHDRAWAL_EXISTS'
            );
        }

        if (User::getAvailableBalance($user->id) < $request->amount) {
            return ApiResponse::error(
                'Insufficient balance',
                [],
                400,
                'INSUFFICIENT_BALANCE'
            );
        }

        $withdrawal = DB::transaction(function () use ($user, $request) {
            $withdrawal = WithdrawalRequest::createWithdrawal(
                $user->id,
                $request->amount,
                $request->method,
                $request->account_details,
                $request->ifsc_code ?? null
            );

            WithdrawalLog::logWithdrawal(
                $user->id,
                $withdrawal->id,
                'requested',
                "User requested withdrawal of ₹{$request->amount}"
            );

            return $withdrawal;
        });

        RateLimiter::hit($key, 3600); // 1 hour decay

        return ApiResponse::success(
            $withdrawal,
            'Withdrawal request submitted successfully'
        );
    }

    /**
     * List user's withdrawal history
     */
    public function withdrawals(Request $request)
    {
        $withdrawals = WithdrawalRequest::getUserWithdrawals($request->user()->id);

        return ApiResponse::success(
            $withdrawals,
            'Withdrawal history fetched successfully'
        );
    }

    /**
     * Get wallet summary
     */
    public function getWalletSummary(Request $request)
    {
        $userId = $request->user()->id;

        $summary = [
            'lifetime_earned' => User::getApprovedEarnings($userId),
            'redeemed' => User::getWithdrawnAmount($userId),
            'rejected' => User::getRejectedEarnings($userId),
            'pending' => User::getPendingEarnings($userId),
            'available' => User::getAvailableBalance($userId),
        ];

        return ApiResponse::success(
            $summary,
            'Wallet summary fetched successfully'
        );
    }

    /**
     * List user's transactions
     */
    public function getTransactions(Request $request)
    {
        $transactions = Transaction::getUserTransactions($request->user()->id, 20);

        return ApiResponse::success(
            $transactions,
            'Transaction list fetched successfully'
        );
    }

    /**
     * Approve or reject withdrawal (for Admin Panel)
     */
    public function reviewWithdrawal(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validation failed',
                $validator->errors(),
                422,
                'VALIDATION_FAILED'
            );
        }

        $withdrawal = DB::transaction(function () use ($request, $id) {
            $withdrawal = WithdrawalRequest::reviewWithdrawal(
                $id,
                $request->status,
                $request->admin_note
            );

            if ($withdrawal) {
                WithdrawalLog::logWithdrawal(
                    $withdrawal->user_id,
                    $withdrawal->id,
                    $request->status,
                    "Withdrawal {$request->status} by admin: " . ($request->admin_note ?? 'No note')
                );

                if ($request->status === 'approved') {
                    Transaction::createDebitTransaction(
                        $withdrawal->user_id,
                        $withdrawal->amount,
                        'Withdrawal processed',
                        ['withdrawal_id' => $withdrawal->id]
                    );
                }
            }

            return $withdrawal;
        });

        if (!$withdrawal) {
            return ApiResponse::error(
                'Withdrawal not found or not authorized',
                [],
                404,
                'WITHDRAWAL_NOT_FOUND'
            );
        }

        return ApiResponse::success(
            $withdrawal,
            "Withdrawal {$request->status} successfully"
        );
    }
}

