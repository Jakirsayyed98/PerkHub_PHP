<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class affiliate_transaction extends Model
{
    use HasFactory;
    public $table ='miniapp_transaction';
    protected $fillable = [
        'user_id',
        'campaign_id',
        'miniapp_id',
        'commission',
        'user_commission',
        'subid1',
        'subid2',
        'subid3',
        'sale_amount',
        'commission_percentage',
        'transaction_amt',
        'transaction_id',
        'transaction_date',
        'transaction_status',
        'reference_id'
    ];



    function SaveAndUpdateTransaction($transaction_id,$user_id,$campaign_id,$miniapp_id,$commission,$user_commission,$subid1,$subid2,$subid3,$sale_amount,$commission_percentage,$transaction_amt,$transaction_date,$transaction_status,$reference_id){
        $model = affiliate_transaction::where('transaction_id',$transaction_id)->first();
        if($model){
            $model->update([
                'user_id'=>$user_id,
                'campaign_id'=>$campaign_id,
                'miniapp_id'=>$miniapp_id,
                'commission'=>$commission,
                'user_commission'=>$user_commission,
                'subid1'=>$subid1,
                'subid2'=>$subid2,
                'subid3'=>$subid3,
                'sale_amount'=>$sale_amount,
                'commission_percentage'=>$commission_percentage,
                'transaction_amt'=>$transaction_amt,
                'transaction_date'=>$transaction_date,
                'transaction_status'=>$transaction_status,
                'reference_id'=>$reference_id
            ]);
        }else{
            affiliate_transaction::create([
                'user_id'=>$user_id,
                'campaign_id'=>$campaign_id,
                'miniapp_id'=>$miniapp_id,
                'commission'=>$commission,
                'user_commission'=>$user_commission,
                'subid1'=>$subid1,
                'subid2'=>$subid2,
                'subid3'=>$subid3,
                'sale_amount'=>$sale_amount,
                'commission_percentage'=>$commission_percentage,
                'transaction_amt'=>$transaction_amt,
                'transaction_date'=>$transaction_date,
                'transaction_status'=>$transaction_status,
                'reference_id'=>$reference_id
            ]);
        }
    }
}
