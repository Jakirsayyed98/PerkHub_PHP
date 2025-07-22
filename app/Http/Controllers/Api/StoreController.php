<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\ClickLog;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * List active stores with tracking URLs
     */
    public function list(Request $request)
    {
        $userId = Auth::user()->id;
        $stores = Store::getActiveStoresWithTracking($userId);

        return ApiResponse::success($stores, 'Stores fetched successfully');
    }

    /**
     * Show specific store details with tracking URL
     */
    public function detail(Request $request, $id)
    {
        $userId = Auth::user()->id;
        $store = Store::getStoreByIdWithTracking($id, $userId);

        if (!$store) {
            return ApiResponse::error(
                'Store not found',
                [],
                404,
                'STORE_NOT_FOUND'
            );
        }

        return ApiResponse::success($store, 'Store details fetched successfully');
    }

    /**
     * Track store click and generate tracking URL
     */
    public function trackStoreClick(Request $request, $id)
    {
        $userId = Auth::user()->id;
        $store = Store::getActiveStoreById($id);

        if (!$store || !$store->affiliate_url) {
            return ApiResponse::error(
                'Store not found or no tracking URL',
                [],
                404,
                'STORE_NOT_FOUND'
            );
        }

        // Log the click
        $subid1 = (string) $store->id;
        $subid2 = (string) $userId;
        ClickLog::logClick($store->id, $userId, $subid1, $subid2);

        // Generate tracking URL
        $finalUrl = Store::buildTrackingUrl($store->affiliate_url, $subid1, $subid2);

        return ApiResponse::success([
            'redirect_url' => $finalUrl,
        ], 'Tracking URL generated successfully');
    }
}