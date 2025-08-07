<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\banners;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    //

    function bannerlist(Request $req){
        $banners = banners::where("banner_category_id",$req->id)->get();
        for ($i=0; $i < $banners->count(); $i++) { 
            $banners[$i]->image = $this->getImageWithUrl($banners[$i]->image);
        }
        return view('adminpanel/banners/banners',['records'=>$banners,'banner_id'=>$req->id]);
    }

    function bannerAddOrUpdate(Request $req){
        $banners = banners::find($req->id);
        $bannerType = $req->banner_id;
        return view('adminpanel/banners/addOrEditBanner',['records'=>$banners,'bannerType'=>$bannerType]);
    }
    

    function deleteBanner(Request $req){
        $id = $req->id;
        banners::where('id',$id)->delete();
        
        return redirect('bannerlist?id='.$req->banner_id);

    }

    function ActiveDeactivebanner(Request $req){
        $banners = banners::find($req->id);
        if($banners->status=="0"){
            $banners->status = "1";
        }else{
            $banners->status = "0";
        }
        $banners->save();
        
        $banners = banners::where("banner_id",$req->banner_id)->get();
        return redirect('bannerlist?id='.$req->banner_id);
    }

    function AddOrUpdateBannerProcess(Request $req){
        $banner_category_id = $req->banner_type;
        $id = $req->id;
        $name = $req->name;
        $url = $req->url;

        $bannerRes = banners::find($id);

        if(is_null($bannerRes)){
            $banner =new banners;
            if($req->hasfile('image')){
                $banner->image =$this->imageSave($req);
            }
            $banner->name = $name;
            $banner->url = $url;
            $banner->banner_category_id = $banner_category_id;
            $banner->status = true;
            $banner->save();

        }else{

            if($req->hasfile('image')){
                $bannerRes->image =$this->imageSave($req);
            }
            $bannerRes->name = $name;
            $bannerRes->url = $url;
            $bannerRes->banner_category_id = $banner_category_id;
            $banner->status = true;
            $bannerRes->save();
        }
        return redirect('bannerlist?id='.$req->banner_type);
    }
}
