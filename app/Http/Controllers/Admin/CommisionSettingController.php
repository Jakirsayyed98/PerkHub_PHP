<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\affiliatecommision_setting;

class CommisionSettingController extends Controller
{
    //

    function CommisionSetting(Request $req) {
        $list = affiliatecommision_setting::where('status','1')->get();
        return view('adminpanel/settings/commision_setting',['records'=>$list]);
    }

    function CommisionSettingAddOrUpdate(Request $req) {
        $id = $req->id;
        $list = affiliatecommision_setting::find($id);
        return view('adminpanel/settings/AffaliateSettingDetail',['records'=>$list]);
    }
    
    function CommisionSettingAddOrUpdateProcess(Request $req) {
       

        $id = $req->id;
        $Affiliate_name = $req->Affiliate_name;
        $user_commision = $req->user_commision;
        $API_KEY = $req->API_KEY;
        $channel_name = $req->channel_name;
        $status = $req->status;

        $list = affiliatecommision_setting::find($id);

        if(is_null($list)){
            $list =new affiliatecommision_setting;
        }else{
            $list = affiliatecommision_setting::find($id);
        }

        $list->Affiliate_name = $Affiliate_name;
        $list->user_commision = $user_commision;
        $list->API_KEY = $API_KEY;
        $list->channel_name = $channel_name;
        $list->status = $status;
        $list->save();

        return redirect('commision_setting');
    }

}
