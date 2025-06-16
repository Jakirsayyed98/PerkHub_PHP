<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\affiliate_transaction;
use App\Models\UserModel;
use App\Models\subid_data;



class AffiliateController extends Controller
{
    public function CueLinkCallback(Request $request){
        $campaign_id      = $request->query('campaign_id');
        $commission       = $request->query('commission');
        $reference_id     = $request->query('reference_id');
        $sale_amount      = $request->query('sale_amount');
        $status           = $request->query('status');
        $subid            = $request->query('subid');
        $subid1           = $request->query('subid1');
        $subid2           = $request->query('subid2'); // user id
        $subid3           = $request->query('subid3');
        $transaction_date = $request->query('transaction_date');
        $transaction_id   = $request->query('transaction_id');
        $user_commission = "33%";
        $commission_percentage = "13%";

        $subIdData =new subid_data();
        $subIdData->getDataBySubId($subid);

        $transactionData = new affiliate_transaction();
        $transactionData->SaveAndUpdateTransaction($transaction_id,$subid2,$campaign_id,$subIdData->brand_id,$commission,$user_commission,$subid1,$subid2,$subid3,$sale_amount,$commission_percentage,$sale_amount,$transaction_date,$status,$reference_id);  

        // You can log or process these values as needed
    Log::info('Callback received', $request->all());
    
    return $this->SendSuccessResponse('0', [], 'Callback received successfully');
    }
}