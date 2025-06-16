<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lootoffers;
use App\Models\MiniAppData;
use Validator;
use App\Models\UserModel;

class LootOffersController extends Controller
{
    //

    function getAllLootoffers(Request $req) {
        // $result = lootoffers::all();
        $user_id = $req->attributes->get('user_id');

        $user = UserModel::where('user_id',$user_id)->get();
        
        if($user->count()>0){
        $pageNumber =1;// $req->page;
        $result = lootoffers::paginate($pageNumber);
        
        if($result){
            for ($i=0; $i < $result->count() ; $i++) { 
                $miniApp = MiniAppData::where('id',$result[$i]->miniAppID)->get();
                // $result[$i]->image =asset('upload/images/'.$result[$i]->image);

                if(isset($miniApp[0]->icon)){
                    $miniApp[0]->icon = asset('upload/images/'.$miniApp[0]->icon);
                }else{
                    $miniApp[0]->icon ='';
                }

                if(isset($miniApp[0]->logo)){
                    $miniApp[0]->logo = asset('upload/images/'.$miniApp[0]->logo);
                }else{
                    $miniApp[0]->logo ='';
                }

                if(isset($miniApp[0]->banner)){
                    $miniApp[0]->banner = asset('upload/images/'.$miniApp[0]->banner);
                }else{
                    $miniApp[0]->banner ='';
                }


                $result[$i]->MiniApps = [$miniApp[0]] ; 
            }

           

            $response = $result;
            return response()->json($response,200);
            // return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'loot offers not found');
        }


    }else{
        $response = [];
        return $this->sendResponse('1',$response,'User not found');
    }
    }
   
   
    function searchLootoffers(Request $req) {
        $validator = Validator::make($req->all(),[
            'user_id'=>'required',
            'search'=>'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('1',[],$validator->errors()->first());
            
        }

        $user_id = $req->user_id;
        $user = UserModel::where('id',$user_id)->get();
        
        if($user->count()>0){


        $result = lootoffers::where('title','like','%'.$req->search.'%')->get();
        if($result){
            for ($i=0; $i < $result->count() ; $i++) { 
                $miniApp = MiniAppData::where('id',$result[$i]->miniAppID)->get();
                // $result[$i]->image =asset('upload/images/'.$result[$i]->image);

                if(isset($miniApp[0]->icon)){
                    $miniApp[0]->icon = asset('upload/images/'.$miniApp[0]->icon);
                }else{
                    $miniApp[0]->icon ='';
                }

                if(isset($miniApp[0]->logo)){
                    $miniApp[0]->logo = asset('upload/images/'.$miniApp[0]->logo);
                }else{
                    $miniApp[0]->logo ='';
                }

                if(isset($miniApp[0]->banner)){
                    $miniApp[0]->banner = asset('upload/images/'.$miniApp[0]->banner);
                }else{
                    $miniApp[0]->banner ='';
                }


                $result[$i]->MiniApps = [$miniApp[0]] ; 
            }

           
            $response = $result;
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'loot offers not found');
        }

    }else{
        $response = [];
        return $this->sendResponse('1',$response,'User not found');
    }

    }
}
