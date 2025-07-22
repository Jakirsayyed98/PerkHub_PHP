<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * List authenticated user's orders with pagination
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 20); // Default 20 orders per page

        $orders = Order::getUserOrders($user->id, $perPage);

        return ApiResponse::success(
            $orders,
            'User orders retrieved successfully'
        );
    }

    /**
     * Show specific order details for authenticated user
     */
    public function show($id)
    {
        $user = Auth::user();

        $order = Order::getUserOrderById($user->id, $id);

        if (!$order) {
            return ApiResponse::error(
                'Order not found or not authorized',
                [],
                404,
                'ORDER_NOT_FOUND'
            );
        }

        return ApiResponse::success(
            $order,
            'Order details retrieved successfully'
        );
    }
}