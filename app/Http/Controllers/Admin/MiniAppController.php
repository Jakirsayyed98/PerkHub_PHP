<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AffiliateProvider;
use App\Models\StoresCategories;
use App\Models\miniapp_subcategoriesModel;
use App\Models\affiliatecommision_setting;
use App\Models\Store;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BulkExport;



class MiniAppController extends Controller
{
    //

    
    function MiniAppList(Request $req){
        $miniapp = Store::paginate(100);
        $category = (new StoresCategories)->getAllCategories();
        return view('adminpanel/miniApp/miniappList',['records'=>$miniapp,'category'=>$category]);
    }

    function popularActiveDeactivefun(Request $req){
         $miniapp = Store::find($req->id);

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
        $miniapp = Store::find($req->id);

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
        $miniapp = Store::find($req->id);

        if($miniapp->top_cashback=="1"){ 
            $miniapp->top_cashback=  "0";
        } else {
            $miniapp->top_cashback=  "1";
        };
        $miniapp->save();

        return redirect('MiniAppList');
    }

    function miniAppActiveDeactive(Request $req){
        $miniapp = Store::find($req->id);

        if($miniapp->status=="1"){ 
            $miniapp->status=  "0";
        } else {
            $miniapp->status=  "1";
        };
        $miniapp->save();

        return redirect('MiniAppList');
    }

    

    function UpdateMiniApps(Request $req){
        $miniapp = Store::find($req->id);
        $category = StoresCategories::where('status','1')->get();
        $affiliate_partner = (new AffiliateProvider)->getActiveProviders();
        return view('adminpanel/miniApp/UpdateMiniAppDetail',['records'=>$miniapp,'category'=>$category,'affiliate_partner'=>$affiliate_partner]);

    }

    function AllMicroServiceUpdate(Request $req){
        $data = (new Stores)->getAllStores();
        for ($i=0; $i < $data->count(); $i++){
            $miniApp = MiniAppData::find($data[$i]->id);
            $miniApp->macro_publisher = "1";
            $miniApp->save();
        }

    }
    
    function updateProcessData(Request $req){
        $id = $req->id;
        $data = Store::find($id);

        if (is_null($data)) {
            $miniApp = new Store;
        } else {
            $miniApp = $data;
        }

        $miniApp->name = $req->name;
        $miniApp->store_category_id = $req->category_id;
        $miniApp->url_type = $req->url_type;
        $miniApp->affiliate_provider_id = $req->macro_publisher;
        $miniApp->cb_active = $req->cb_active; // ✅ fixed (was cd_active)
        $miniApp->description = $req->description;
        $miniApp->url = $req->url;
        $miniApp->label = $req->label;
        $miniApp->cashback = $req->cb_percentage;
        $miniApp->how_its_work = $req->work;
        $miniApp->about_store = $req->about;
        $miniApp->terms_and_conditions = $req->cashback_terms;

        if ($req->hasFile('icon')) {
            $miniApp->icon = $this->saveOnPath($req->file('icon'), "icon");
        }

        if ($req->hasFile('logo')) {
            $miniApp->logo = $this->saveOnPath($req->file('logo'), "logo");
        }

        if ($req->hasFile('banner')) {
            $miniApp->banner = $this->saveOnPath($req->file('banner'), "banner");
        }

        $miniApp->save();

        return redirect('MiniAppList');
    }

    function deleteMiniApp(Request $req){
        $id = $req->id;
        Store::where('id',$id)->delete();
        
        return redirect('MiniAppList');
    }

    function ExportExcel(Request $req) {
        $miniapp = Store::all();
        return Excel::download(new BulkExport, 'MiniAppData.xlsx');
    }

}