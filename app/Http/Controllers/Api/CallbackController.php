<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Helpers\ApiResponse;

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

        $order = Order::processCallback(
            'cuelinks',
            $request->only([
                'reference_id',
                'order_id',
                'order_amount',
                'affiliate_commission',
                'subid1',
                'subid2',
                'status'
            ])
        );

        if (!$order) {
            return ApiResponse::error(
                'Failed to process callback: Invalid provider, store, or user',
                [],
                400,
                'CALLBACK_PROCESSING_FAILED'
            );
        }

        return ApiResponse::success(
            ['order_id' => $order->id],
            'Callback processed successfully'
        );
    }
}