<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\affiliate_transaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BulkMiniAppTxn;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use Crypt; 

class MiniAppTransactionController extends Controller
{
    //
    function MiniApptransaction(Request $req){
       $txn = affiliate_transaction::where('transaction_status','1')->get();
       return view('adminpanel/transaction/miniApp_transaction',['records'=>$txn]);
    }


    function BulkMiniAppTxn()  {
        
        return Excel::download(new BulkMiniAppTxn, 'MiniAppTxn.xlsx');
    }




    

    function UploadTxn(Request $req){
        $file = $req->file('excel_file');
        $data = Excel::toCollection([], $file)[0];
       
        

        for ($i=0; $i <$data->count() ; $i++) { 
            $txn = affiliate_transaction::find($data[$i]);
            if(is_null($txn)){

            }else{

                if($data[$i][13]==''){

                    DB::table('affiliate_transaction')
                    ->where('subId', $data[$i][9])
                    ->update([
                        'update_status' => "0",
                    ]);



                }else if($data[$i][13]=='NULL'){

                    DB::table('affiliate_transaction')
                    ->where('subId', $data[$i][9])
                    ->update([
                        'update_status' => "0",
                    ]);
                }else{

            
                    if($data[$i][18]=="0"){

                        $user = UserModel::find($data[$i][1]);


                        $totalCommision = $data[$i][14];
                        $CommisionPercentage = $data[$i][15];
                        $user_commission = ($totalCommision/100) * $CommisionPercentage;
                      

                        $pending = $user->pending;
                        $rejected = $user->rejected;
                        $verified = $user->verified;
                        
                        
                        if($data[$i][17]=="0"){
                            $user->pending = ($pending+$user_commission);
                        }else if($data[$i][17]=="1"){
                            $user->verified = ($verified+$user_commission);
                        }else if($data[$i][17]=="2"){
                            $user->rejected = ($rejected+$user_commission);
                        }
                        $user->save();

                  
                        DB::table('affiliate_transaction')
                        ->where('subId', $data[$i][9])
                        ->update([
                            'campaign_id' => $data[$i][2],
                            'transaction_id' => $data[$i][6],
                            'reference_id' => $data[$i][7],
                            'transaction_date' => $data[$i][8],
                            'sale_amount' => $data[$i][13],
                            'affiliate_commission' => $data[$i][14],
                            'user_commission' =>$user_commission,
                            'status' => $data[$i][17],
                            'update_status' => "1",
                        ]);

                    }else{

                        DB::table('affiliate_transaction')
                        ->where('subId', $data[$i][9])
                        ->update([
                            'status' => $data[$i][17],
                        ]);
                    }
                }
            
        }
        }
        return redirect('MiniApptransaction');
    }

    function UpdateMiniAppTxn(Request $req){
        $txn = affiliate_transaction::find($req->id)->get();
       return view('adminpanel/transaction/miniApp_transaction_update',['records'=>$txn]);
    }

}