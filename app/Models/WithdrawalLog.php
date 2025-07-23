<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalLog extends Model
{
    protected $fillable = ['user_id', 'withdrawal_id', 'action', 'description', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function withdrawal()
    {
        return $this->belongsTo(WithdrawalRequest::class);
    }

    public static function logWithdrawal($userId, $withdrawalId, $action, $description)
    {
        return self::create([
            'user_id' => $userId,
            'withdrawal_id' => $withdrawalId,
            'action' => $action,
            'description' => $description,
            'created_at' => now(),
        ]);
    }
}