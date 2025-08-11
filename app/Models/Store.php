<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name', 'affiliate_provider_id', 'icon', 'logo', 'banner',
        'about_store', 'terms_and_conditions', 'label', 'cashback', 'active'
    ];

    public function affiliateProvider()
    {
        return $this->belongsTo(AffiliateProvider::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function getActiveStoresWithTracking($userId)
    {
        return self::where('active', true)
            ->with('affiliateProvider')
            ->get()
            ->map(function ($store) use ($userId) {
                $store->tracking_url = self::buildTrackingUrl($store->affiliateProvider->name, $store->id, $userId);
                return $store;
            });
    }

    public static function getStoreByIdWithTracking($id, $userId)
    {
        $store = self::where('id', $id)->where('active', true)->with('affiliateProvider')->first();
        if ($store) {
            $store->tracking_url = self::buildTrackingUrl($store->affiliateProvider->name, $store->id, $userId);
        }
        return $store;
    }

    public static function getActiveStoreById($id)
    {
        return self::where('id', $id)->where('active', true)->first();
    }

    public static function buildTrackingUrl($providerName, $subid1, $subid2)
    {
        $baseUrl = config("affiliate.providers.{$providerName}.base_url", '');
        return $baseUrl . '?subid1=' . urlencode($subid1) . '&subid2=' . urlencode($subid2);
    }

     public function getAllStores(){
        return self::all();
    }

    public function getStoresByCategory($categoryId)
    {
        return self::where('store_category_id', $categoryId)->orWhere('status',true)->get();
    }

    public function getPopularStores(){
        $stores = Store::where('status', true)
            ->where('popular', true)
            // ->select('id', 'name', 'icon', 'logo', 'banner', 'url', 'cashback')
            ->take(10)
            ->get()
            ->map(function ($store) {
                    $store->icon = $store->icon ? url('upload/images/' . $store->icon) : null;
                    $store->logo = $store->logo ? url('upload/images/' . $store->logo) : null;
                    $store->banner = $store->banner ? url('upload/images/' . $store->banner) : null;
                    return $store;
                });

                return $stores;

    }

    public function getTrendingStores(){
        $stores = Store::where('status', true)
            ->where('trending', true)
            // ->select('id', 'name', 'icon', 'logo', 'banner', 'url', 'cashback')
            ->take(10)
            ->get()
            ->map(function ($store) {
                $store->icon = $store->icon ? url('upload/images/' . $store->icon) : null;
                $store->logo = $store->logo ? url('upload/images/' . $store->logo) : null;
                $store->banner = $store->banner ? url('upload/images/' . $store->banner) : null;
                return $store;
            });

        return $stores;
    }

    public function getTopCashbackStores(){
        $stores = Store::where('status', true)
            ->where('top_cashback', true)
            // ->select('id', 'name', 'icon', 'logo', 'banner', 'url', 'cashback')
            ->take(10)
            ->get()
            ->map(function ($store) {
                $store->icon = $store->icon ? url('upload/images/' . $store->icon) : null;
                $store->logo = $store->logo ? url('upload/images/' . $store->logo) : null;
                $store->banner = $store->banner ? url('upload/images/' . $store->banner) : null;
                return $store;
            });

        return $stores;
    }
}