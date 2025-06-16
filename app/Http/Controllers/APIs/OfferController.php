<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\offers;
use App\Models\MiniAppData;
use App\Models\UserModel;


class OfferController extends Controller
{
    //

    function getAllOffers(Request $req) {
        $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
        $user = (new UserModel)->getUserByUserId($user_id);
        if (!$user){
            return $this->sendResponse('1', [], 'User not found');
        }

       

        $result =(new offers)->getOfferPaginate($request["limit"] ?? 10);
        
        if (!$result){
            return $this->sendResponse('1', [], 'No offers found');
        }

        if($result->count()>0){
           

            for ($i=0; $i < $result->count() ; $i++) { 
            //    echo $result[$i]->miniapp_id;
            //    die;
               $miniApp = (new MiniAppData)->getMiniAppByMiniAppNameOrId($result[$i]->miniapp_id);
               
                if(isset($miniApp->icon)){
                    $miniApp->icon = asset('upload/images/'.$miniApp->icon);
                }else{
                    $miniApp->icon ='';
                }

                if(isset($miniApp->logo)){
                    $miniApp->logo = asset('upload/images/'.$miniApp->logo);
                }else{
                    $miniApp->logo ='';
                }

                if(isset($miniApp->banner)){
                    $miniApp->banner = asset('upload/images/'.$miniApp->banner);
                }else{
                    $miniApp->banner ='';
                }


                $result[$i]->MiniApps = [$miniApp]; 
            }

            $response = $result;
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Offers not found');
        }
    }
}
