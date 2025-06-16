<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MiniAppData;
use App\Models\affiliate_transaction;
use App\Models\UserModel;
use App\Models\subid_data;

class MiniAppTxnController extends Controller
{

    function GenerateMiniAppSubId(Request $req){
        $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
    
        $user = (new UserModel)->getUserByUserId($user_id);        
        if($user->count()>0){
            $miniApp =(new MiniAppData)->getMiniAppByMiniAppNameOrId($request['name']);
            if($miniApp->count()>0){
                // $this->printRawData($miniApp);
                $miniAppId = $miniApp->id;
                $subid1 = $this->generateRandomUUID(20);
                $url = sprintf('%s&subid=%s&subid2=%s&subid3=%s', $miniApp->url,$subid1,$user_id,$miniApp->name.$miniAppId);
                $miniApp->url = $url;
                subid_data::InsertSubId($user_id, $miniAppId, $subid1);
                return $this->sendResponse('0',$url,'Successfully');
            }
        }
        
        return $this->sendResponse('1',[],'Error');
    }
  

    function getTxnList(Request $req){

        $validator = Validator::make($req->all(),[
            'user_id'=>'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('1',[],$validator->errors()->first());
            
        }


        $user_id = $req->user_id;
       

        $model1 = affiliate_transaction::where('user_id',$user_id)->where('update_status','1')->orderBy('created_at', 'desc')->get();
    

        if($model1){
            for ($i=0; $i < $model1->count(); $i++) { 
                // $result = MiniAppData::where('id',$model1[$i]->miniapp_id)->get();
                $result = MiniAppData::find($model1[$i]->miniapp_id);
                if($result){
                       if(isset($result->icon)){
                            $result->icon = asset('public/upload/images/'.$result->icon);
                        }else{
                            $result->icon ='';
                        }
        
                        if(isset($result->logo)){
                            $result->logo = asset('public/upload/images/'.$result->logo);
                        }else{
                            $result->logo ='';
                        }
        
                        if(isset($result->banner)){
                            $result->banner = asset('public/upload/images/'.$result->banner);
                        }else{
                            $result->banner ='';
                        }
           
                    $model1[$i]->miniApp = [$result];
                    
                }else{
                    $model1[$i]->miniApp = [];
                   
                }
            }
            $response = $model1;
            return $this->sendResponse('0',$response,'Successfully');

        }else{
        
            $response = [];
            return $this->sendResponse('1',$response,'Error');
        }

    }
}
