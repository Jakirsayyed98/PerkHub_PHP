<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use App\Models\MiniAppData;
use Illuminate\Support\Facades\Crypt;


class CueLinkController extends Controller
{
    //
    //*
    public function handleCallback(Request $req)
    {
        $payload =   $req->getContent();//input('payload');
        $subid = $req->subid;
        $sale_amount = $req->sale_amount;
        $status = $req->status;
        if ($status) {
            $sub_id = $subid;
            $status =$status;
           
            
            if ($sub_id && $status) {
              
                if ($status === 'Payble') {
        
                    DB::table('affiliate_transaction')
                    ->where('subId', $subid)
                    ->update([
                        'status' => "1",
                    ]);



                }  elseif ($status === 'Validated') {
                   
                    $data = DB::table('affiliate_transaction')->where('subId', $subid)->get();

                    if($data->count()>0){

                        $user = UserModel::find($data[0]->user_id);

                        $pendingAmount = $user->pending;
                        $verifiedAmount = $user->verified;
                        $commision = $data[0]->user_commission;
    
                        $user->pending = $pendingAmount-$commision;
                        $user->verified = $verifiedAmount+$commision;
                        
                        $user->save();
    
    
                        DB::table('affiliate_transaction')
                        ->where('subId', $subid)
                        ->update([
                            'status' => "1",
                        ]);
                        
                        $title="Your cashback is Verified";
                        $body = "Your cashback from ".$data[0]->campaign_name." is Verified successfully";
                        $miniapp = MiniAppData::find($data[0]->miniapp_id);
                        $image = asset('public/upload/images/'.$miniapp->icon);
                        $this->sendNotification($user->FCMtoken,$title,$body,$image,"2",$data[0]->user_id);
                    }else{
                        return response('SubId not found.', 200);
                    }
                   
                    
                    

                } elseif ($status === 'pending') {
                    
                    
                    $commision = $req->commision;
                    $transaction_date = $req->transaction_date;
                    $reference_id = $req->reference_id;
                    $transaction_id = $req->transaction_id;
                    $campaign_id = $req->campaign_id;

                    
                    $data = DB::table('affiliate_transaction')->where('subId', $subid)->get();
                    
                    if($data->count()>0){
                        
                    $user = UserModel::find($data[0]->user_id);
                    
                    $totalCommision = $commision;
                    $CommisionPercentage = $data[0]->user_commission_percentage;
                    $user_commission = ($totalCommision/100) * $CommisionPercentage;
                    $pendingAmount = $user->pending;
                   
                    $user->pending = $pendingAmount+$user_commission;
                    $user->save();
                    
                    

                    DB::table('affiliate_transaction')
                    ->where('subId', $subid)
                    ->update([
                        'campaign_id' => $campaign_id,
                            'transaction_id' => $transaction_id,
                            'reference_id' => $reference_id,
                            'transaction_date' => $transaction_date,
                            'sale_amount' => $sale_amount,
                            'affiliate_commission' => $commision,
                            'user_commission' =>$user_commission,
                            'status' =>'0',
                            'update_status' => "1",
                    ]);
                   
                        $title="Your transaction is Tracked";
                        $body = "Your transaction from ".$data[0]->campaign_name." is Tracked successfully";
                        $miniapp = MiniAppData::find($data[0]->miniapp_id);
                        $image = asset('public/upload/images/'.$miniapp->icon);
                        $this->sendNotification($user->FCMtoken,$title,$body,$image,"2",$data[0]->user_id);
                        
                    }else{
                        return response('SubId not found.', 200);
                    }
                   
                }elseif ($status === 'Pending') {


                    $commision = $req->commision;
                    $transaction_date = $req->transaction_date;
                    $reference_id = $req->reference_id;
                    $transaction_id = $req->transaction_id;
                    $campaign_id = $req->campaign_id;
                    $data = DB::table('affiliate_transaction')->where('subId', $subid)->get();
                    if($data->count()>0){
                       
                    $user = UserModel::find($data[0]->user_id);
                    $totalCommision = $commision;
                        $CommisionPercentage = $data[0]->user_commission_percentage;
                        $user_commission = ($totalCommision/100) * $CommisionPercentage;
                        $pendingAmount = $user->pending;
                    $user->pending = $pendingAmount+$user_commission;
                    $user->save();
                   
                    DB::table('affiliate_transaction')
                    ->where('subId', $subid)
                    ->update([
                        
                            'campaign_id' => $campaign_id,
                            'transaction_id' => $transaction_id,
                            'reference_id' => $reference_id,
                            'transaction_date' => $transaction_date,
                            'sale_amount' => $sale_amount,
                            'affiliate_commission' => $commision,
                            'user_commission' =>$user_commission,
                            'status' =>'0',
                            'update_status' => "1",
                    ]);

                 
                    $title="Your transaction is Tracked";
                    $body = "Your transaction from ".$data[0]->campaign_name." is Tracked successfully";
                    $miniapp = MiniAppData::find($data[0]->miniapp_id);
                    $image = asset('public/upload/images/'.$miniapp->icon);
                    $this->sendNotification($user->FCMtoken,$title,$body,$image,"2",$data[0]->user_id);
                }else{
                    return response('SubId not found.', 200);
                }


                } elseif ($status === 'rejected') {

                    $data = DB::table('affiliate_transaction')->where('subId', $subid)->get();
                    if($data->count()>0){
                    $user = UserModel::find($data[0]->user_id);

                    $pendingAmount = $user->pending;
                    if($user->rejected=='0') {
                        $RejectedAmount = $user->rejected;
                    }else{
                        $RejectedAmount = $user->rejected;
                    } 
                   
                    
                    $commision = $data[0]->user_commission;

                    $user->pending =$pendingAmount-$commision;

                
                    $user->rejected = $RejectedAmount+$commision;
                    
                    $user->save();


                    DB::table('affiliate_transaction')
                    ->where('subId', $subid)
                    ->update([
                        'status' => "2",
                    ]);

                
                    $title="Your cashback is Rejected";
                    $body = "Your cashback from ".$data[0]->campaign_name." is Rejected";
                    $miniapp = MiniAppData::find($data[0]->miniapp_id);
                    $image = asset('public/upload/images/'.$miniapp->icon);
                    $this->sendNotification($user->FCMtoken,$title,$body,$image,"2",$data[0]->user_id);
                       }else{
                        return response('SubId not found.', 200);
                    }
                } elseif ($status === 'Rejected') {

                    $data = DB::table('affiliate_transaction')->where('subId', $subid)->get();
                    if($data->count()>0){
                    $user = UserModel::find($data[0]->user_id);
                    
                    $pendingAmount = $user->pending;
                    if($user->rejected=='0') {
                        $RejectedAmount = $user->rejected;
                    }else{
                        $RejectedAmount = $user->rejected;
                    } 
                   
                    $commision = $data[0]->user_commission;

                    $user->pending = $pendingAmount-$commision;

                    $user->rejected =$RejectedAmount+$commision;
                    
                    $user->save();


                    DB::table('affiliate_transaction')
                    ->where('subId', $subid)
                    ->update([
                        'status' => "2",
                    ]);

                    $title="Your cashback is Rejected";
                    $body = "Your cashback from ".$data[0]->campaign_name." is Rejected";
                    $miniapp = MiniAppData::find($data[0]->miniapp_id);
                    $image = asset('public/upload/images/'.$miniapp->icon);
                    $this->sendNotification($user->FCMtoken,$title,$body,$image,"2",$data[0]->user_id);
                    }else{
                        return response('SubId not found.', 200);
                    }
                }

                // Send a response to CueLinks
                $response = $status;
                return response('Callback received successfully.', 200);
            }
        }

        // If payload is missing or invalid, return an error
        return response('Error: Invalid request.', 400);
    }
}