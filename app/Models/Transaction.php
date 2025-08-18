<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
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
            ->orderByDesc('transaction_date');
    }

    public static function createDebitTransaction($userId, $amount,  $transactionId)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'withdrawal',
            'amount' => $amount,
            'transaction_id'=>$transactionId,
            'status' => 'approved',
            'transaction_date' => now(),
        ]);
    }

    public static function getTotalOfUserTransactions($userId = null)
    {
        $query = self::select(
            'status',
            DB::raw("SUM(CASE WHEN type = 'cashback' THEN amount ELSE 0 END) as total_cashback"),
            DB::raw("SUM(CASE WHEN type = 'withdrawal' THEN amount ELSE 0 END) as total_withdrawal")
        )
        ->groupBy('status');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $data = $query->get();

        // Format into array [status => [cashback, withdrawal]]
        $totals = [
            'pending' => ['cashback' => 0, 'withdrawal' => 0],
            'approved' => ['cashback' => 0, 'withdrawal' => 0],
            'rejected' => ['cashback' => 0, 'withdrawal' => 0],
        ];

        foreach ($data as $row) {
            $totals[$row->status]['cashback'] = $row->total_cashback;
            $totals[$row->status]['withdrawal'] = $row->total_withdrawal;
        }

        return $totals;
    }

}