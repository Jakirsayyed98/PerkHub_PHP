<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\MiniAppCategoriesModel;
use App\Models\miniapp_subcategoriesModel;
use App\Models\affiliatecommision_setting;
use App\Models\MiniAppData;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BulkExport;



class MiniAppController extends Controller
{
    //

    
    function MiniAppList(Request $req){
        $miniapp = MiniAppData::paginate(100);
        $category = MiniAppCategoriesModel::all();
        return view('adminpanel/miniApp/miniappList',['records'=>$miniapp,'category'=>$category]);
    }

    function popularActiveDeactivefun(Request $req){
         $miniapp = MiniAppData::find($req->id);

        if($miniapp->popular=="1"){ 
            $miniapp->popular=  "0";
        } else {
            $miniapp->popular=  "1";
        };
        $miniapp->save();

        return redirect('MiniAppList');
    }

    function trendingActiveDeactive(Request $req){
        // echo "<pre>";
        // print_r($req->all());
        // die;
        $miniapp = MiniAppData::find($req->id);

        if($miniapp->trending=="1"){ 
            $miniapp->trending=  "0";
        } else {
            $miniapp->trending=  "1";
        };
        $miniapp->save();

        return redirect('MiniAppList');
    }

    function top_cashbackActiveDeactive(Request $req){
        // echo "<pre>";
        // print_r($req->all());
        // die;
        $miniapp = MiniAppData::find($req->id);

        if($miniapp->top_cashback=="1"){ 
            $miniapp->top_cashback=  "0";
        } else {
            $miniapp->top_cashback=  "1";
        };
        $miniapp->save();

        return redirect('MiniAppList');
    }

    function miniAppActiveDeactive(Request $req){
        $miniapp = MiniAppData::find($req->id);

        if($miniapp->status=="1"){ 
            $miniapp->status=  "0";
        } else {
            $miniapp->status=  "1";
        };
        $miniapp->save();

        return redirect('MiniAppList');
    }

    

    function UpdateMiniApps(Request $req){
        $miniapp = MiniAppData::find($req->id);
        $category = MiniAppCategoriesModel::where('status','1')->get();
        $affiliate_partner = affiliatecommision_setting::where('status','1')->get();
        return view('adminpanel/miniApp/UpdateMiniAppDetail',['records'=>$miniapp,'category'=>$category,'affiliate_partner'=>$affiliate_partner]);

    }

    function AllMicroServiceUpdate(Request $req){
        $data = MiniAppData::all();
        for ($i=0; $i < $data->count(); $i++){
            $miniApp = MiniAppData::find($data[$i]->id);
            $miniApp->macro_publisher = "1";
            $miniApp->save();
        }

    }
    
    function updateProcessData(Request $req){
        $id = $req->id;
        $name = $req->name;
        $category_id = $req->category_id;
        $url_type = $req->url_type;
        $macro_publisher = $req->macro_publisher;
        $cb_active = $req->cb_active;
        $description = $req->description;
        $url = $req->url;
        $label = $req->label;
        $cb_percentage = $req->cb_percentage;
        $howitswork= $req->work;
        $about = $req->about;
        $cashback_terms = $req->cashback_terms;
        $data = MiniAppData::find($id);
        if(is_null($data)){
            $miniApp =new MiniAppData;
        }else{
            $miniApp = MiniAppData::find($id);
        }
        
        // $miniApp->id = $id;
        $miniApp->name = $name;
        $miniApp->miniapp_category_id = $category_id;
        $miniApp->url_type = $url_type;
        $miniApp->macro_publisher = $macro_publisher;
        $miniApp->cb_active = $cb_active;
        $miniApp->description = $description;
        $miniApp->url = $url;
        $miniApp->label = $label;
        $miniApp->cb_percentage = $cb_percentage;
        $miniApp->howitswork= $howitswork;
        $miniApp->about =$about;
        $miniApp->cashback_terms =$cashback_terms;

        if($req->hasfile('icon')){
            $miniApp->icon =$this->saveOnPath($req->file('icon'),"icon");
        }

        if($req->hasfile('logo')){
            $miniApp->logo =$this->saveOnPath($req->file('logo'),"logo");
        }

        if($req->hasfile('banner')){
            $miniApp->banner = $this->saveOnPath($req->file('banner'),"banner");
        }
        
        $miniApp->save();
       return redirect('MiniAppList');
    }

    function deleteMiniApp(Request $req){
        $id = $req->id;
        MiniAppData::where('id',$id)->delete();
        
        return redirect('MiniAppList');
    }

    function ExportExcel(Request $req) {
        $miniapp = MiniAppData::all();
        return Excel::download(new BulkExport, 'MiniAppData.xlsx');
    }

}