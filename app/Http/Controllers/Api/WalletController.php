<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;
use App\Models\WithdrawalLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class WalletController extends Controller
{
    public function withdraw(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:upi,bank',
            'account_details' => 'required|string|max:255',
            'ifsc_code' => 'required_if:method,bank|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
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

        $key = 'withdraw:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return ApiResponse::error(
                'You can only request one withdrawal per hour',
                [],
                429,
                'RATE_LIMIT_EXCEEDED'
            );
        }

        $wallet = Wallet::where('user_id', $user->id)->first();
        if (!$wallet || (float) Crypt::decrypt($wallet->balance) < $request->amount) {
            return ApiResponse::error(
                'Insufficient balance',
                [],
                400,
                'INSUFFICIENT_BALANCE'
            );
        }

        if (WithdrawalRequest::where('user_id', $user->id)->where('status', 'pending')->exists()) {
            return ApiResponse::error(
                'You already have a pending withdrawal request',
                [],
                409,
                'PENDING_WITHDRAWAL_EXISTS'
            );
        }

        $withdrawal = DB::transaction(function () use ($user, $request, $wallet) {
            $withdrawal = WithdrawalRequest::create([
                'user_id' => $user->id,
                'amount' => Crypt::encrypt($request->amount),
                'method' => $request->method,
                'account_details' => $request->account_details,
                'ifsc_code' => $request->ifsc_code,
                'requested_at' => now(),
            ]);

            WithdrawalLog::create([
                'user_id' => $user->id,
                'withdrawal_id' => $withdrawal->id,
                'action' => 'requested',
                'description' => "User requested withdrawal of ₹{$request->amount}",
            ]);

            $balance = (float) Crypt::decrypt($wallet->balance) - $request->amount;
            $pending = (float) Crypt::decrypt($wallet->pending) + $request->amount;
            $wallet->update([
                'balance' => Crypt::encrypt($balance),
                'pending' => Crypt::encrypt($pending),
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'amount' => Crypt::encrypt($request->amount),
                'type' => 'withdrawal',
                'status' => 'pending',
                'transaction_date' => now(),
            ]);

            return $withdrawal;
        });

        RateLimiter::hit($key, 3600);

        $withdrawal->amount = (float) Crypt::decrypt($withdrawal->amount);
        return ApiResponse::success(
            $withdrawal,
            'Withdrawal request submitted successfully'
        );
    }

    public function withdrawals(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = WithdrawalRequest::where('user_id', Auth::id());

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('requested_at', [$startDate, $endDate]);
        }

        $withdrawals = $query->orderBy('requested_at', 'desc')
            ->paginate($perPage)
            ->through(function ($withdrawal) {
                $withdrawal->amount = (float) Crypt::decrypt($withdrawal->amount);
                return $withdrawal;
            });

        return ApiResponse::success(
            $withdrawals,
            'Withdrawal history fetched successfully'
        );
    }

    public function getWalletSummary(Request $request)
    {
        $userId = Auth::id();
        $wallet = Wallet::where('user_id', $userId)->first();

        $summary = [
            'lifetime_earnings' => $wallet ? (float) Crypt::decrypt($wallet->lifetime_earnings) : 0,
            'withdrawn' => $wallet ? (float) Crypt::decrypt($wallet->withdrawn) : 0,
            'rejected' => $wallet ? (float) Crypt::decrypt($wallet->rejected) : 0,
            'pending' => $wallet ? (float) Crypt::decrypt($wallet->pending) : 0,
            'available' => $wallet ? (float) Crypt::decrypt($wallet->balance) : 0,
        ];

        return ApiResponse::success(
            $summary,
            'Wallet summary fetched successfully'
        );
    }

    public function transactions(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $type = $request->input('type');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::where('user_id', Auth::id())
            ->with(['store' => function ($query) {
                $query->select('id', 'name', 'icon', 'logo', 'banner', 'cashback');
            }]);

        if ($type) {
            $query->where('type', $type);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->paginate($perPage)
            ->through(function ($transaction) {
                $transaction->amount = (float) Crypt::decrypt($transaction->amount);
                $transaction->cashback = $transaction->cashback ? (float) Crypt::decrypt($transaction->cashback) : null;
                return $transaction;
            });

        return ApiResponse::success(
            $transactions,
            'Transaction list fetched successfully'
        );
    }

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
            $withdrawal = WithdrawalRequest::where('id', $id)
                ->where('status', 'pending')
                ->first();

            if (!$withdrawal) {
                return null;
            }

            $wallet = Wallet::where('user_id', $withdrawal->user_id)->first();

            $withdrawal->update([
                'status' => $request->status,
                'admin_note' => $request->admin_note,
                'processed_at' => now(),
            ]);

            if ($request->status === 'approved') {
                $pending = (float) Crypt::decrypt($wallet->pending) - (float) Crypt::decrypt($withdrawal->amount);
                $withdrawn = (float) Crypt::decrypt($wallet->withdrawn) + (float) Crypt::decrypt($withdrawal->amount);
                $wallet->update([
                    'pending' => Crypt::encrypt($pending),
                    'withdrawn' => Crypt::encrypt($withdrawn),
                ]);

                Transaction::where('user_id', $withdrawal->user_id)
                    ->where('type', 'withdrawal')
                    ->where('amount', $withdrawal->amount)
                    ->where('status', 'pending')
                    ->update(['status' => 'approved']);
            } elseif ($request->status === 'rejected') {
                $pending = (float) Crypt::decrypt($wallet->pending) - (float) Crypt::decrypt($withdrawal->amount);
                $rejected = (float) Crypt::decrypt($wallet->rejected) + (float) Crypt::decrypt($withdrawal->amount);
                $balance = (float) Crypt::decrypt($wallet->balance) + (float) Crypt::decrypt($withdrawal->amount);
                $wallet->update([
                    'pending' => Crypt::encrypt($pending),
                    'rejected' => Crypt::encrypt($rejected),
                    'balance' => Crypt::encrypt($balance),
                ]);

                Transaction::where('user_id', $withdrawal->user_id)
                    ->where('type', 'withdrawal')
                    ->where('amount', $withdrawal->amount)
                    ->where('status', 'pending')
                    ->update(['status' => 'rejected']);
            }

            WithdrawalLog::create([
                'user_id' => $withdrawal->user_id,
                'withdrawal_id' => $withdrawal->id,
                'action' => $request->status,
                'description' => "Withdrawal {$request->status} by admin: " . ($request->admin_note ?? 'No note'),
            ]);

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

        $withdrawal->amount = (float) Crypt::decrypt($withdrawal->amount);
        return ApiResponse::success(
            $withdrawal,
            "Withdrawal {$request->status} successfully"
        );
    }
}