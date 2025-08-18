<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Store;
use App\Models\StoresCategories;
use App\Models\banners;
use App\Models\ClickLog;
use Illuminate\Support\Str;
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

public function trackStoreClick(Request $request)
{
    $id = $request->id;
    $user = Auth::user();

    $store = Store::where('id', $id)
        ->where('active', true)
        ->with(['affiliateProvider' => function ($query) {
            $query->select('id', 'name', 'base_url', 'status');
        }])
        ->first();

    if (!$store || !$store->affiliate_provider_id /*|| $store->affiliateProvider->status !== '1'*/) {
        return ApiResponse::error(
            'Store not found or inactive',
            [],
            404,
            'STORE_NOT_FOUND'
        );
    }

    // Generate subids
    $subid = 'S' . $store->id . '_' . Str::uuid()->toString();
    $subid2 = (string) $user->uuid;

    // Build Affiliate Tracking URL = Provider base + Store deeplink + subids
    $baseUrl = $store->url;   // e.g. cuelinks tracking URL
    $storeDeeplink = $store->deeplink_url;            // ✅ store-specific deeplink (must be in DB)
    
    $trackingUrl = $baseUrl . (str_contains($baseUrl, '?') ? '&' : '?') . http_build_query([
        'url'    => $storeDeeplink,   // store's landing page
        'subid1' => $subid,
        'subid2' => $subid2,
    ]);

    // Store Click Log
    ClickLog::create([
        'store_id'      => $store->id,
        'user_id'       => $user->id,
        'subid'         => $subid,
        'subid2'        => $subid2,
        'clicked_at'    => now(),
        'tracking_url'  => $trackingUrl,
    ]);

    return ApiResponse::success($trackingUrl, 'Store tracking URL generated successfully');
}



      public function getHomepageData(Request $request)
    {
        Cache::forget('homepage_data');
        // Cache the response for 10 minutes
        $data = Cache::remember('homepage_data', 600, function () {
            // Fetch store categories (active and homepage visible)
            $categories = (new StoresCategories)->getAllCategories();

            // Fetch popular stores
            $popularStores =(new Store)->getPopularStores();
            // Fetch trending stores
            $trendingStores = (new Store)->getTrendingStores();

            // Fetch top cashback providers
            $topCashbackStores =(new Store)->getTopCashbackStores();
            
            $newBanner = (new banners);
            $banners1 = $newBanner->getBannerByBannerCategoryId("1");
            $banners2 = $newBanner->getBannerByBannerCategoryId("2");
            $banners3 = $newBanner->getBannerByBannerCategoryId("3");

            return [
                'store_categories' => $categories,
                'popular_stores' => $popularStores,
                'trending_stores' => $trendingStores,
                'top_cashback_providers' => $topCashbackStores,
                'banner1' => $banners1,
                'banner2' => $banners2,
                'banner3' => $banners3,
            ];
        });

        return ApiResponse::success($data, 'Homepage data retrieved successfully');
    }

    function getStoreByCategory(Request $request)
    {
        
        $categoryId = $request->input('category_id');
        $stores = (new Store)->getStoresByCategory($categoryId);

        return ApiResponse::success($stores, 'Stores retrieved successfully');
    }
}