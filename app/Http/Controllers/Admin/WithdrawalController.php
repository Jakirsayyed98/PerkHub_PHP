<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\WithdrawalRequest;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\WithdrawalLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');
        $status = $request->input('status');

        $query = WithdrawalRequest::with(['user' => function ($query) {
            $query->select('id', 'name', 'email', 'mobile');
        }]);

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $withdrawals = $query->orderBy('requested_at', 'desc')
            ->paginate($perPage)
            ->through(function ($withdrawal) {
                $withdrawal->amount = (float) Crypt::decrypt($withdrawal->amount);
                return $withdrawal;
            });

        return ApiResponse::success($withdrawals, 'Withdrawals retrieved successfully');
    }

    public function review(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422, 'VALIDATION_FAILED');
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
            return ApiResponse::error('Withdrawal not found or not authorized', [], 404, 'WITHDRAWAL_NOT_FOUND');
        }

        $withdrawal->amount = (float) Crypt::decrypt($withdrawal->amount);
        return ApiResponse::success($withdrawal, "Withdrawal {$request->status} successfully");
    }
}