<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\offers;
use App\Models\MiniAppData;

class OfferController extends Controller
{
    //

    function offerlist(Request $req) {

        $result =(new offers)->getOfferPaginate(10);
        return view('adminpanel/offers/offerlist',['records'=>$result]);
        
    }
   
    function AddOrUpdateOffer(Request $req) {

        $result =(new offers)->getOfferById($req->id);
        $miniAppList =(new MiniAppData)->getMiniAppList();
        

        return view('adminpanel/offers/AddORUpdateOffer',['records'=>$result,'miniAppList'=>$miniAppList]);
        
    }
   
    function OfferActiveDeactive(Request $req) {

        $result =(new offers)->getOfferById($req->id);
        if($result->status=="1"){
            $result->status="0";
        }else{
            $result->status="1";
        };
        $result->save();

        return redirect('offerlist');
        
    }



    function deleteOfferProcess(Request $req) {

        $result =(new offers)->deleteOfferById($req->id);
        return redirect('offerlist');
        
    }


    function ProcessAddOrUpdate(Request $req){
        $id = $req->id;
        $title = $req->title;
        $image = $req->image_url;
        $end_date = $req->end_date;
        $url = $req->url;
        $coupon_code = $req->coupon_code;
        $miniAppID = $req->miniAppID;
        $type = $req->type;
        $status = $req->status;
        $terms = $req->terms;

        $exist = (new offers)->getOfferById($id);

        if(is_null($exist)){
            $result = new offers;
        }else{
            $result = (new offers)->getOfferById($id);
        }

        $result->title = $title;
        $result->image = $image;
        $result->end_date = $end_date;
        $result->url = $url;
        $result->coupon_code = $coupon_code;
        $result->miniapp_id = $miniAppID;
        $result->type = $type;
        $result->status = $status;
        $result->terms = $terms;
        $result->save();

        return redirect('offerlist');

    }

}
