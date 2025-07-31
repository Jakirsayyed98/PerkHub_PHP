<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\affiliate_transaction;
use App\Models\WithdrawalRequest;

class WithdrawalController extends Controller
{
    //
    function WithdrawalList(Request $req){
        $status = $req->status;
        $records = (new WithdrawalRequest)->getByStatus($status);
        return view('adminpanel/withdrawal/withdrawallist',['records'=>$records]);
    }
    
    
    function withdrawalstatusupdate(Request $req){
        $id = $req->query('id'); // or $req->id
        
        $record =(new WithdrawalRequest)->getById($req->id);
        
        $usermodel =(new UserModel)->getUserByUserId($record->user_id);
       
        $transaction = affiliate_transaction::where('user_id',$record->user_id)->where('transaction_status','1')->get();
        // $this->printRawData($transaction);
        return view('adminpanel/withdrawal/withdrawalstatusupdate',['records'=>$record,'usermodel'=>$usermodel,'transaction'=>$transaction]);
    }

    function withdrawalstatusupdateProcess(Request $req){
        $txn_id=$req->txn_id;
        $message=$req->message;
        $txn_time=$req->txn_time;
        $withdrawal_status=$req->withdrawal_status;
        $withdrawalamount=$req->withdrawalamount;
        $usermodel =(new UserModel)->getUserByUserId($req->user_id);
        if (!$usermodel) {
            return back()->with('error', 'User not found.');
        }
       
        // Now it's safe to use:
        $token = $usermodel->FCMtoken ?? "";
        $records =(new WithdrawalRequest)->getById($req->id);
        if (!$records) {
            // Handle the error, e.g.:
            return back()->with('error', 'Withdrawal request not found.');
        }
        
        // Now it's safe to use:
        $WithdrawalUpdate = (new WithdrawalRequest)->UpdateWithdrawalRequest($req->id, $txn_id, $message, $txn_time, $withdrawal_status);
        if (!$WithdrawalUpdate) {
            return back()->with('error', 'Failed to update withdrawal request.');
        }

        if($withdrawal_status=="1"){ 
            $title="Your withdrawal of ₹".$withdrawalamount ." has been Completed";
            $body = "Your balance will credit to your account within 24hrs";
            $image = '';
            $this->sendNotification($token,$title,$body,$image,"2",$req->user_id);
        } else if($withdrawal_status=="2") {
            $title="Your withdrawal of ₹".$withdrawalamount ." has been Rejected";
            $body = "Because ".$message;
            $image = '';
            $this->sendNotification($token,$title,$body,$image,"2",$req->user_id);
        }
       
       
        return redirect('WithdrawalList?status=0')->with('success', 'Withdrawal request updated successfully.');

    }
}
