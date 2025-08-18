<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
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
        
        $record =(new WithdrawalRequest)->getWithdrawalRequestbyId($req->id);
        
        $usermodel =(new User)->getUserByUserId($record->user_id);

        $transaction = Transaction::getTotalOfUserTransactions($req->id);

        $pendingCashback = $transaction['pending']['cashback'] ?? 0;
        $approvedCashback = $transaction['approved']['cashback'] ?? 0;
        $rejectedCashback = $transaction['rejected']['cashback'] ?? 0;
        $withdrawalAmount = $transaction['withdrawal']['amount'] ?? 0;
        $transaction = Transaction::getUserTransactions($record->user_id, 'approved');
        // $this->printRawData($transaction);
        return view('adminpanel/withdrawal/withdrawalstatusupdate',['records'=>$record,'usermodel'=>$usermodel,'transaction'=>$transaction,
            'pendingCashback' => $pendingCashback,
            'approvedCashback' => $approvedCashback,
            'rejectedCashback' => $rejectedCashback,
            'withdrawalAmount' => $withdrawalAmount
        ]);
    }

    function withdrawalstatusupdateProcess(Request $req){
       $txn_id = $req->txn_id;
    $message = $req->admin_note;
    $txn_time = $req->txn_time;
    $withdrawal_status = $req->withdrawal_status;
    $withdrawalamount = $req->requested_amount;
       
        $usermodel =(new User)->getUserByUserId($req->user_id);
        if (!$usermodel) {
            return back()->with('error', 'User not found.');
        }
       
        // Now it's safe to use:
        $token = $usermodel->FCMtoken ?? "";
        $records =(new WithdrawalRequest)->getWithdrawalRequestbyId($req->id);
        if (!$records) {
            // Handle the error, e.g.:
            return back()->with('error', 'Withdrawal request not found.');
        }
        
        // Now it's safe to use:
        $WithdrawalUpdate = (new WithdrawalRequest)->UpdateWithdrawalRequest($req->id, $txn_id, $message, $txn_time, $withdrawal_status);
        if (!$WithdrawalUpdate) {
            return back()->with('error', 'Failed to update withdrawal request.');
        }

        
        
        if ($withdrawal_status == "approved") {
            $txn = (new Transaction)->createDebitTransaction($req->user_id, $withdrawalamount, $req->id);
        } 

        // if($withdrawal_status=="approved"){ 
        //     $title="Your withdrawal of ₹".$withdrawalamount ." has been Completed";
        //     $body = "Your balance will credit to your account within 24hrs";
        //     $image = '';
        //     $this->sendNotification($token,$title,$body,$image,"2",$req->user_id);
        // } else if($withdrawal_status=="rejected") {
        //     $title="Your withdrawal of ₹".$withdrawalamount ." has been Rejected";
        //     $body = "Because ".$message;
        //     $image = '';
        //     $this->sendNotification($token,$title,$body,$image,"2",$req->user_id);
        // }
       
       
        return redirect('WithdrawalList?status=pending')->with('success', 'Withdrawal request updated successfully.');

    }
}
