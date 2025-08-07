<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lootoffers;
use App\Models\MiniAppData;

class LootOffersController extends Controller
{
    //
    function lootOfferList(Request $req)  {
        
        $records = lootoffers::all();
        $miniAppList = MiniAppData::all();
        return view('adminpanel/lootoffers/lootoffers',['records'=>$records, 'miniAppList'=>$miniAppList]);
    }

    function AddOrUpdateLootOffers(Request $req)  {


        $records = lootoffers::find($req->id);
        $miniAppList =(new MiniAppData)->getAllMiniApps();
    
        // echo "<pre>";
        // print_r($records);
        // echo "</pre>";
        // die;


        return view('adminpanel/lootoffers/AddOrUpdateLootOffers',['records'=>$records , 'miniAppList'=>$miniAppList]);
    }



    function updateLootOfferProcess(Request $req)  {
        $records = lootoffers::find($req->id);
        $title = $req->title;
        $description = $req->description;
        $price = $req->price;
        $dis_price = $req->dis_price;
        $url = $req->url;
        $image_url = $req->image_url;
        $status = $req->status;
        $end_date = $req->end_date;
        $coupon_code = $req->coupon_code;
        $coupon_status = $req->coupon_status;
        $miniAppID = $req->miniAppID;

        if(is_null($records)){
          $result =new lootoffers;
          }else{
            $result = lootoffers::find($req->id);
        }

        $result->title =$title;
            
        $result->description = $description;
        $result->price = $price;
        $result->dis_price = $dis_price;
        $result->url = $url;
        $result->status = $status;
        $result->end_date = $end_date;
        $result->coupon_code = $coupon_code;
        $result->coupon_status = $coupon_status;
        $result->image =$image_url;
        $result->miniAppID =$miniAppID;


        // if($req->hasfile('image')){
        //     $file = $req->file('image');
        //     $extention = $file->getClientOriginalExtension();
        //     $filename = time()."image".".".$extention;
        //     $file->move('upload/images/',$filename);
        //     $result->image =$filename;
            
        // }

    
        $result->save();

        return redirect('lootOfferList');

    }


    function DeleteLootOffers(Request $req) {
        $result = lootoffers::find($req->id);
        $result->delete();
        return redirect('lootOfferList');
    }

    
    function ActivateDeactivateLootOffers(Request $req) {
        $result = lootoffers::find($req->id);
        $result->delete();
        return redirect('lootOfferList');
    }

}