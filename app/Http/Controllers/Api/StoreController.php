<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Store;
use App\Models\StoresCategories;
use App\Models\ClickLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


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

    public function getHomepageData(Request $request)
    {
        // Cache the response for 10 minutes
        $data = Cache::remember('homepage_data', 600, function () {
            // Fetch store categories (active and homepage visible)
            $categories = StoresCategories::where('status', true)
                ->where('homepage_visible', true)
                ->select('id', 'name', 'description', 'image')
                ->get();

            // Fetch popular stores
            $popularStores = Store::where('status', true)
                ->where('popular', true)
                ->with(['affiliateProvider' => function ($query) {
                    $query->select('id', 'name'); // Assuming users table has a name field
                }])
                ->select('id', 'name', 'icon', 'logo', 'banner', 'url', 'cashback', 'affiliate_provider_id')
                ->take(10) // Limit to 10 for performance
                ->get();

            // Fetch trending stores
            $trendingStores = Store::where('status', true)
                ->where('trending', true)
                ->with(['affiliateProvider' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->select('id', 'name', 'icon', 'logo', 'banner', 'url', 'cashback', 'affiliate_provider_id')
                ->take(10)
                ->get();

            // Fetch top cashback providers
            $topCashbackStores = Store::where('status', true)
                ->where('top_cashback', true)
                ->with(['affiliateProvider' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->select('id', 'name', 'icon', 'logo', 'banner', 'url', 'cashback', 'affiliate_provider_id')
                ->take(10)
                ->get();

            return [
                'store_categories' => $categories,
                'popular_stores' => $popularStores,
                'trending_stores' => $trendingStores,
                'top_cashback_providers' => $topCashbackStores,
            ];
        });


         return ApiResponse::success($data, 'Homepage data retrieved successfully');
    }

}