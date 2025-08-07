<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Store;
use App\Models\AffiliateProvider;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'store_count' => Store::count(),
            'affiliate_count' => AffiliateProvider::count(),
            'user_count' => User::count(),
            'transaction_count' => Transaction::count(),
            'withdrawal_request_count' => WithdrawalRequest::count(),
        ];

        return ApiResponse::success($stats, 'Dashboard data retrieved successfully');
    }
}