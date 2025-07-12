<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiniAppTransaction extends Model
{
    use HasFactory;
    protected $table = 'miniapp_transactions'; // Optional if class name matches table name

    protected $fillable = [
        'user_id',
        'campaign_id',
        'miniapp_id',
        'sale_amount',
        'commission_percentage',
        'commission',
        'user_commission',
        'transaction_amt',
        'transaction_id',
        'transaction_date',
        'transaction_status',
        'reference_id',
        'subid',
        'subid1',
        'subid2',
        'subid3',
    ];

public static function saveOrUpdateByUserSubid(
    string $transactionId,
    string $userId,
    string $campaignId,
    string $miniAppId,
    string $commission,
    string $userCommission,
    string $subid,
    string $subid1,
    string $subid2,
    string $subid3,
    string $saleAmount,
    string $commissionPercentage,
    string $transactionAmt,
    $transactionDate,
    string $transactionStatus,
    string $referenceId
): void {
    $data = [
        'transaction_id'        => $transactionId,
        'campaign_id'           => $campaignId,
        'miniapp_id'            => $miniAppId,
        'commission'            => $commission,
        'user_commission'       => $userCommission,
        'subid'                 => $subid,
        'subid1'                => $subid1,
        'subid2'                => $subid2,
        'subid3'                => $subid3,
        'sale_amount'           => $saleAmount,
        'commission_percentage' => $commissionPercentage,
        'transaction_amt'       => $transactionAmt,
        'transaction_date'      => $transactionDate,
        'transaction_status'    => $transactionStatus,
        'reference_id'          => $referenceId,
    ];

    $record = self::where('user_id', $userId)
        ->where('subid', $subid)
        ->first();

    if ($record) {
        $record->update($data);
    } else {
        self::create(array_merge($data, [
            'user_id' => $userId,
            'subid'  => $subid,
        ]));
    }
}

    public function GetTransaction($userId){
        $model = MiniAppTransaction::where('user_id',$userId)->orderBy('created_at', 'desc')->get();
        if($model){
            return $model;
        }
        return null;
    }
}
