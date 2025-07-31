<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Crypt;

class CallbackController extends Controller
{
    public function handle(Request $request)
    {
        return ApiResponse::error(
            'Please use the Cuelinks callback endpoint',
            [],
            400,
            'GENERIC_CALLBACK_DEPRECATED'
        );
    }

    public function handleCuelinks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference_id' => 'required|string',
            'order_id' => 'nullable|string',
            'order_amount' => 'required|numeric|min:0',
            'affiliate_commission' => 'required|numeric|min:0',
            'subid1' => 'required|string', // store_id
            'subid2' => 'required|string', // user_id
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Invalid callback data',
                $validator->errors(),
                422,
                'INVALID_CALLBACK_DATA'
            );
        }

        $data = $request->only([
            'reference_id',
            'order_id',
            'order_amount',
            'affiliate_commission',
            'subid1',
            'subid2',
            'status'
        ]);

        $order = Order::where('affiliate_provider_id', function ($query) {
            $query->select('id')
                ->from('affiliate_providers')
                ->where('name', 'cuelinks')
                ->first();
        })
        ->where('reference_id', $data['reference_id'])
        ->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => $data['subid2'],
                'store_id' => $data['subid1'],
                'affiliate_provider_id' => function ($query) {
                    $query->select('id')
                        ->from('affiliate_providers')
                        ->where('name', 'cuelinks')
                        ->first();
                },
                'reference_id' => $data['reference_id'],
                'order_id' => $data['order_id'],
                'transaction_date' => now(),
                'order_amount' => Crypt::encrypt($data['order_amount']),
                'affiliate_commission' => Crypt::encrypt($data['affiliate_commission']),
                'user_commission' => Crypt::encrypt($data['affiliate_commission'] * 0.8),
                'user_commission_percent' => 80.00,
                'status' => $data['status'],
                'subid' => $data['subid1'],
                'subid1' => $data['subid1'],
                'subid2' => $data['subid2'],
            ]);
        } else {
            $order->update([
                'order_id' => $data['order_id'],
                'order_amount' => Crypt::encrypt($data['order_amount']),
                'affiliate_commission' => Crypt::encrypt($data['affiliate_commission']),
                'user_commission' => Crypt::encrypt($data['affiliate_commission'] * 0.8),
                'status' => $data['status'],
            ]);
        }

        $wallet = Wallet::where('user_id', $data['subid2'])->first();
        if ($data['status'] === 'approved') {
            if (!$wallet) {
                $wallet = Wallet::create([
                    'user_id' => $data['subid2'],
                    'balance' => Crypt::encrypt(0),
                    'pending' => Crypt::encrypt($data['affiliate_commission'] * 0.8),
                    'withdrawn' => Crypt::encrypt(0),
                    'rejected' => Crypt::encrypt(0),
                    'lifetime_earnings' => Crypt::encrypt($data['affiliate_commission'] * 0.8),
                ]);
            } else {
                $pending = (float) Crypt::decrypt($wallet->pending) + ($data['affiliate_commission'] * 0.8);
                $lifetime_earnings = (float) Crypt::decrypt($wallet->lifetime_earnings) + ($data['affiliate_commission'] * 0.8);
                $wallet->update([
                    'pending' => Crypt::encrypt($pending),
                    'lifetime_earnings' => Crypt::encrypt($lifetime_earnings),
                ]);
            }

            Transaction::create([
                'user_id' => $data['subid2'],
                'store_id' => $data['subid1'],
                'amount' => Crypt::encrypt($data['order_amount']),
                'cashback' => Crypt::encrypt($data['affiliate_commission'] * 0.8),
                'transaction_id' => $data['order_id'],
                'subid' => $data['subid1'],
                'type' => 'cashback',
                'status' => 'pending',
                'transaction_date' => now(),
            ]);
        } elseif ($data['status'] === 'rejected') {
            if ($wallet) {
                $rejected = (float) Crypt::decrypt($wallet->rejected) + ($data['affiliate_commission'] * 0.8);
                $wallet->update([
                    'rejected' => Crypt::encrypt($rejected),
                ]);
            }
        }

        return ApiResponse::success(
            ['order_id' => $order->id],
            'Callback processed successfully'
        );
    }
}