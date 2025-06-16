<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Models\banners;
use App\Models\HomePageModel;
use App\Models\MiniAppCategoriesModel;
use App\Models\MiniAppData;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIs\MiniAppTxnController;
use App\helper;
use App\Models\UserModel;
use App\Models\affiliate_transaction;
use Validator;
use App\Models\affiliatecommision_setting;

class HomePageController extends Controller
{
    //
    
    function getHomePage(Request $req){
        $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
    
        $user = UserModel::where('user_id',$user_id)->get();
        
        if($user->count()>0){

        $banner1 = banners::where('banner_category_id','1')->where('status','1')->get();
        for ($i=0; $i < $banner1->count(); $i++) { 
             $banner1[$i]->image = $this->getImageWithUrl($banner1[$i]->image);
            // $banner1[$i]->image = "http://192.168.209.107:8001/upload/images/".$banner1[$i]->image;
        }

        $banner2 = banners::where('banner_category_id','2')->where('status','1')->get();
        for ($i=0; $i < $banner2->count(); $i++) { 
            $banner2[$i]->image = $this->getImageWithUrl($banner2[$i]->image);
        }

        $banner3 = banners::where('banner_category_id','3')->where('status','1')->get();
        for ($i=0; $i < $banner3->count(); $i++) { 
            $banner3[$i]->image = $this->getImageWithUrl($banner3[$i]->image);
        }



        $categories = MiniAppCategoriesModel::where('status','1')->get();
        for ($i=0; $i < $categories->count(); $i++) { 
            $categories[$i]->image = $this->getImageWithUrl($categories[$i]->image);
        }


        $popular = MiniAppData::where('status','1')->where('popular','1')->get();
        for ($i=0; $i < $popular->count(); $i++) { 
            $popular[$i]->icon =$this->getImageWithUrl($popular[$i]->icon);
            $popular[$i]->logo =$this->getImageWithUrl($popular[$i]->logo);
            $popular[$i]->banner = $this->getImageWithUrl($popular[$i]->banner);
        }

        $topcashback = MiniAppData::where('status','1')->where('top_cashback','1')->get();
        for ($i=0; $i < $topcashback->count(); $i++) { 
            $topcashback[$i]->icon = $this->getImageWithUrl($topcashback[$i]->icon);
            $topcashback[$i]->logo =$this->getImageWithUrl($topcashback[$i]->logo);
            $topcashback[$i]->banner = $this->getImageWithUrl($topcashback[$i]->banner);
        }
        $trending = MiniAppData::where('status','1')->where('trending','1')->get();
        for ($i=0; $i < $trending->count(); $i++) { 
            $trending[$i]->icon =$this->getImageWithUrl($trending[$i]->icon);
            $trending[$i]->logo = $this->getImageWithUrl($trending[$i]->logo);
            $trending[$i]->banner =$this->getImageWithUrl($trending[$i]->banner);
        }

    

        $category1 =MiniAppCategoriesModel::where('status','1')->where('homepage_visible','1')->get();
       
        
        for($i=0; $i <  $category1->count(); $i++){
            $category1[$i]->data = MiniAppData::where('miniapp_category_id', $categories[$i]->id)->where('status','1')->get();
            $category1[$i]->image = $this->getImageWithUrl($category1[$i]->image);
            for ($j=0; $j <  $category1[$i]->data->count(); $j++) { 
                $category1[$i]->data[$j]->icon = $this->getImageWithUrl( $category1[$i]->data[$j]->icon);
                $category1[$i]->data[$j]->logo =$this->getImageWithUrl($category1[$i]->data[$j]->logo);
                $category1[$i]->data[$j]->banner = $this->getImageWithUrl( $category1[$i]->data[$j]->banner);
            }
            
        }
    

        $response = [[
            "banner1"=>$banner1,  
            "banner2"=>$banner2,  
            "banner3"=>$banner3,
            "categories"=>$categories,
            "popular"=>$popular->shuffle()->all(),  
            "top_cashback"=>$topcashback->shuffle()->all(),
            "trending"=>$trending->shuffle()->all(),
            "category_list"=>$category1,
          ]];
    

          if($response){
            return $this->sendResponse('0',$response,'Successful');
          }else{
            return $this->sendResponse('1',[],'error');
          }
        
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'User not found');
        }
    }



    function getMiniAppGenrateSubID(Request $req){
        $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
    
        $user = UserModel::where('user_id',$user_id)->get();
        
        if($user->count()>0){
        $miniapp_id = $req->miniapp_id;
        $miniapp =MiniAppData::find($miniapp_id);
        $subID=substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 19);

        $commision_percentage ="70";// affiliatecommision_setting::find($miniapp->macro_publisher);
        $model = new affiliate_transaction();
        $model->user_id = $user_id;
        $model->campaign_name = $miniapp->name;
        $model->miniapp_id = $miniapp->id;
        $model->macro_publisher = $miniapp->macro_publisher;
        $model->subId = $subID;
        $model->user_commission_percentage = $commision_percentage->user_commision;
    
        $model->save(); 
        $miniapp->url = $miniapp->url .'&subid='.$subID;
        
         return $this->sendResponse('0',[$miniapp],'Successful');


        }else{
            $response = [];
            return $this->sendResponse('1',$response,'User not found');
        }
    }
    
}
