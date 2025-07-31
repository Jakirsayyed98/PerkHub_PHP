<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Store;
use App\Models\ClickLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::where('active', true)
            ->with(['affiliateProvider' => function ($query) {
                $query->select('id', 'name', 'base_url', 'status');
            }])
            ->get()
            ->map(function ($store) {
                $store->cashback = (float) $store->cashback;
                return $store;
            });

        return ApiResponse::success($stores, 'Stores fetched successfully');
    }

    public function show(Request $request, $id)
    {
        $store = Store::where('id', $id)
            ->where('active', true)
            ->with(['affiliateProvider' => function ($query) {
                $query->select('id', 'name', 'base_url', 'status');
            }])
            ->first();

        if (!$store) {
            return ApiResponse::error(
                'Store not found',
                [],
                404,
                'STORE_NOT_FOUND'
            );
        }

        $store->cashback = (float) $store->cashback;

        return ApiResponse::success($store, 'Store details fetched successfully');
    }

    public function trackStoreClick(Request $request, $id)
    {
        $user = Auth::user();
        $store = Store::where('id', $id)
            ->where('active', true)
            ->with(['affiliateProvider' => function ($query) {
                $query->select('id', 'name', 'base_url', 'status');
            }])
            ->first();

        if (!$store || !$store->affiliateProvider || $store->affiliateProvider->status !== 'active') {
            return ApiResponse::error(
                'Store not found or inactive',
                [],
                404,
                'STORE_NOT_FOUND'
            );
        }

        $subid = "store_{$store->id}";
        $subid2 = (string) $user->id;

        ClickLog::create([
            'store_id' => $store->id,
            'user_id' => $user->id,
            'subid' => $subid,
            'subid2' => $subid2,
            'clicked_at' => now(),
        ]);

        $response = Http::withOptions(['verify' => false])->get($store->affiliateProvider->base_url, [
            'subid1' => $store->id,
            'subid2' => $user->id,
        ]);

        if ($response->failed()) {
            \Log::error('Cuelinks request failed', ['error' => $response->body()]);
            return ApiResponse::error('Tracking failed', [], 500);
        }

        $trackingUrl = $response->json()['url'] ?? $store->affiliateProvider->base_url;

        return ApiResponse::success([
            'redirect_url' => $trackingUrl,
        ], 'Tracking URL generated successfully');
    }
}