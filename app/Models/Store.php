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
}