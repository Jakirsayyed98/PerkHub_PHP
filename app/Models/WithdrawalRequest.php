<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $fillable = ['user_id', 'amount', 'method', 'account_details', 'ifsc_code', 'status', 'requested_at', 'processed_at', 'admin_note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createWithdrawal($userId, $amount, $method, $accountDetails, $ifscCode)
    {
        return self::create([
            'user_id' => $userId,
            'amount' => $amount,
            'method' => $method,
            'account_details' => $accountDetails,
            'ifsc_code' => $ifscCode,
            'status' => 'pending',
            'requested_at' => now(),
        ]);
    }

    public static function getUserWithdrawals($userId)
    {
        return self::where('user_id', $userId)
            ->latest()
            ->get();
    }

    public static function reviewWithdrawal($id, $status, $adminNote)
    {
        $withdrawal = self::where('id', $id)->where('status', 'pending')->first();
        if ($withdrawal) {
            $withdrawal->update([
                'status' => $status,
                'admin_note' => $adminNote,
                'processed_at' => $status !== 'pending' ? now() : null,
            ]);
        }
        return $withdrawal;
    }

    public function getAllPendingWithdrawals()
    {
        return self::where('status', 'pending')->get();
    }

    public function getByStatus($status)
    {
        return self::where('status', $status)->get();
    }

    public function getWithdrawalRequestbyId($id)
    {
        return self::find($id);
    }
  public function UpdateWithdrawalRequest($id, $txnId, $message, $txnTime, $withdrawalStatus)
{
    $withdrawal = self::find($id);

    if ($withdrawal) {
        $withdrawal->update([
            'txn_id'       => $txnId,
            'admin_note'   => $message,
            'processed_at' => $txnTime,   // ✅ matches your DB column
            'status'       => $withdrawalStatus,
        ]);

        return true;
    }

    return false;
}

}