<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProvider;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    //
    public function getAffiliateProviders()
    {
        // Logic to retrieve affiliate providers
        $providers = AffiliateProvider::getAllProviders();
        return view('adminpanel/affiliate/affiliate',['records'=>$providers]);
    }

     public function AffiliateAddOrUpdate(Request $req)
    {
        // Logic to retrieve affiliate providers
        $data = AffiliateProvider::getAffiliateProviderById($req->id);
        return view('adminpanel/affiliate/addOrUpdateAffiliate',['data'=>$data]);
    }

    function AffiliateAddOrUpdateProcess(Request $req){
        $data = [
            'id'              => $req->id ?? null,  // or $req->affiliate_id if that's your field name
            'name'            => $req->name,
            'callback_secret' => $req->callback_secret,
            'base_url'        => $req->base_url,
        ];

    // Call the model function
        AffiliateProvider::AffiliateAddOrUpdate($data);
        return redirect('AffiliateProviders');
    }

    function deleteAffiliate(Request $req){
        $id = $req->id;
        AffiliateProvider::DeleteAffiliateProvider($id);
        return redirect('AffiliateProviders');

    }

    function ActiveDeactiveAffiliate(Request $req){
        AffiliateProvider::AffiliateStatusUpdate($req->id);
        return redirect('AffiliateProviders');
    }

}
