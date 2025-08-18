<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    

    protected $fillable = [
        'user_id', 'store_id', 'affiliate_provider_id', 'reference_id', 'order_id',
        'order_amount', 'affiliate_commission', 'user_commission', 'user_commission_percent',
        'status', 'subid', 'subid1', 'subid2', 'subid3', 'transaction_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function affiliateProvider()
    {
        return $this->belongsTo(AffiliateProvider::class);
    }

    public static function getUserOrders($userId, $perPage)
    {
        return self::with('store:id,name,logo')
            ->where('user_id', $userId)
            ->orderByDesc('transaction_date')
            ->paginate($perPage);
    }

    public static function getUserOrdersByStatus($userId, $status)
    {
        return self::where('user_id', $userId)
            ->where('status', $status)
            ->orderByDesc('transaction_date')
            ->get();
    }

    public static function getUserOrderById($userId, $orderId)
    {
        return self::with('store:id,name,logo')
            ->where('user_id', $userId)
            ->where('id', $orderId)
            ->first();
    }

    public static function getOrderByOrderId($orderId)
    {
        return self::where('id', $orderId)
            ->first();
    }

    public static function processCallback($providerName, $data)
    {
        $provider = AffiliateProvider::findByName($providerName);
        $store = Store::where('id', $data['subid1'])->where('active', true)->first();
        $user = User::where('id', $data['subid2'])->first();

        if (!$provider || !$store || !$user) {
            return null;
        }

        $userCommissionPercent = config('cashback.user_commission_percent', 80);
        $userCommission = $data['affiliate_commission'] * ($userCommissionPercent / 100);

        return self::updateOrCreate(
            [
                'affiliate_provider_id' => $provider->id,
                'reference_id' => $data['reference_id'],
            ],
            [
                'user_id' => $user->id,
                'store_id' => $store->id,
                'order_id' => $data['order_id'],
                'order_amount' => $data['order_amount'],
                'affiliate_commission' => $data['affiliate_commission'],
                'user_commission' => $userCommission,
                'user_commission_percent' => $userCommissionPercent,
                'status' => $data['status'],
                'subid' => $data['subid1'],
                'subid1' => $data['subid1'],
                'subid2' => $data['subid2'],
                'transaction_date' => now(),
            ]
        );
    }

   public static function getAllOrders()
{
    return self::orderBy('updated_at', 'desc')->get();
}


    public static function getAllOrdersByPage($perPage = 10)
    {
        return self::with(['user:id,name', 'store:id,name,logo'])
            ->orderByDesc('transaction_date')
            ->paginate($perPage);
    }

}