<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'withdrawal_id',
        'action',
        'description',
        'performed_at',
    ];

    public $timestamps = false;

    /**
     * Log an action to the withdrawal logs table
     */
    public static function log($userId, $withdrawalId, $action, $desc = null)
    {
        return self::create([
            'user_id'      => $userId,
            'withdrawal_id'=> $withdrawalId,
            'action'       => $action,
            'description'  => $desc,
            'performed_at' => now(),
        ]);
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function withdrawal()
    {
        return $this->belongsTo(WithdrawalRequest::class, 'withdrawal_id');
    }
}
