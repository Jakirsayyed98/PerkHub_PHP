<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'type', 'amount', 'reason', 'meta_data', 'status', 'transaction_date'];

    protected $casts = [
        'meta_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public static function getUserTransactions($userId, $perPage)
    {
        return self::with('store:id,name,logo')
            ->where('user_id', $userId)
            ->orderByDesc('transaction_date')
            ->paginate($perPage);
    }

    public static function createDebitTransaction($userId, $amount, $reason, $metaData)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'debit',
            'amount' => $amount,
            'reason' => $reason,
            'meta_data' => $metaData,
            'status' => 'approved',
            'transaction_date' => now(),
        ]);
    }
}