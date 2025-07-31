<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 20);
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Order::where('user_id', $user->id)
            ->with(['store' => function ($query) {
                $query->select('id', 'name', 'icon', 'logo', 'banner', 'cashback');
            }]);

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $orders = $query->orderBy('transaction_date', 'desc')
            ->paginate($perPage)
            ->through(function ($order) {
                $order->order_amount = (float) Crypt::decrypt($order->order_amount);
                $order->affiliate_commission = (float) Crypt::decrypt($order->affiliate_commission);
                $order->user_commission = (float) Crypt::decrypt($order->user_commission);
                return $order;
            });

        return ApiResponse::success(
            $orders,
            'User orders retrieved successfully'
        );
    }

    public function show($id)
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->with(['store' => function ($query) {
                $query->select('id', 'name', 'icon', 'logo', 'banner', 'cashback');
            }])
            ->first();

        if (!$order) {
            return ApiResponse::error(
                'Order not found or not authorized',
                [],
                404,
                'ORDER_NOT_FOUND'
            );
        }

        $order->order_amount = (float) Crypt::decrypt($order->order_amount);
        $order->affiliate_commission = (float) Crypt::decrypt($order->affiliate_commission);
        $order->user_commission = (float) Crypt::decrypt($order->user_commission);

        return ApiResponse::success(
            $order,
            'Order details retrieved successfully'
        );
    }
}