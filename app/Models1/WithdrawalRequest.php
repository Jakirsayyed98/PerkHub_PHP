<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $table = 'withdrawal_request';

    /**
     * Retrieve a withdrawal request by its ID.
     *
     * @param  int  $id
     * @return \App\Models\WithdrawalRequest|null
     */
    public function getById($id)
    {
        return self::where('id', $id)->first();
    }


    /**
     * Retrieve all withdrawal requests with a specific status.
     *
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByStatus($status)
    {
        return self::where('status', $status)->get();
    }

    public function getUserTxnListByUserId($user_id)
    {
        return self::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Retrieve all withdrawal requests with a specific status.
     *
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function UpdateWithdrawalRequest($id, $txn_id, $message, $txn_time, $status)
    {
        return self::where('id', $id)->update([
            'txn_id' => $txn_id,
            'message' => $message,
            'txn_time' => $txn_time,
            'status' => $status,
        ]);
    }
}
