<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\withdrawal_request_model;
use App\Models\UserModel;
use Validator;

class WithdrawalController extends Controller
{
    //
    function requestwithdrawal(Request $req){
        $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
        $user = UserModel::where('user_id',$user_id)->get();
        
        if($user->count()>0){
        $withdrawal_request_model =new withdrawal_request_model();
        $withdrawal_request_model->type = '1';
        $withdrawal_request_model->status = '0';
        $withdrawal_request_model->user_id =$user_id;
        $withdrawal_request_model->VPA_Id = $req->upi_id;
        $withdrawal_request_model->requested_withdrawal_amt = $req->request_amt;
        $withdrawal_request_model->save();
        if($withdrawal_request_model){
            return $this->SendSuccessResponse('0',[],'Successfully');
        }else{
            $response = [];
            return $this->SendErrorResponse('1',$response,'Error');
        }
       }else{
            return $this->SendErrorResponse('1',[],'User not found');
       }
    }
    
    
    function withdrawalTxnList(Request $req){
        $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
        $model1 = withdrawal_request_model::where('user_id',$user_id)->orderBy('created_at', 'desc')->get();
    
        if($model1){
            $response = $model1;
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Error');
        }

    }
}
