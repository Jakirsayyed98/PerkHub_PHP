<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Store extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'icon',
        'banner',
        'category_id',
        'affiliate_source_id',
        'url',
        'cashback_percentage',
        'label',
        'terms',
        'description',
        'cashback_active',
        'is_featured',
        'trending',
        'popular',
    ];

    public static function getActiveStoresWithTracking($userId)
    {
        return self::select('id', 'name', 'label', 'icon', 'cashback_active as cashback_status', 'cashback_percentage as cashback_percent')
            ->where('cashback_active', true)
            ->orderBy('name')
            ->get()
            ->transform(function ($store) use ($userId) {
                $store->subid = strtoupper(Str::random(8)); // Clean affiliate-safe tracking ID
                $store->subid2 = $userId;
                return $store;
            });
    }

    public static function getStoreByIdWithTracking($id, $userId)
    {
        $store = self::select(
                'id',
                'name',
                'label',
                'icon',
                'cashback_active as cashback_status',
                'cashback_percentage as cashback_percent',
                'banner',
                'terms',
                'description',
                'url'
            )
            ->where('cashback_active', true)
            ->findOrFail($id);

        $store->subid = strtoupper(Str::random(8));
        $store->subid2 = $userId;

        return $store;
    }

    public static function getActiveStoreById($id)
    {
        return self::where('id', $id)
                   ->where('cashback_active', true)
                   ->first();
    }

    public static function buildTrackingUrl($baseUrl, $subid, $subid2)
    {
        $query = http_build_query([
            'subid' => $subid,
            'subid2' => $subid2
        ]);

        return str_contains($baseUrl, '?') ? "$baseUrl&$query" : "$baseUrl?$query";
    }

    public function category()
    {
        return $this->belongsTo(StoreCategory::class, 'category_id');
    }

    public function affiliateSource()
    {
        return $this->belongsTo(AffiliateSource::class, 'affiliate_source_id');
    }
}
