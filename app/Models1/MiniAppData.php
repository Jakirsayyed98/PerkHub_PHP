<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiniAppData extends Model
{
    use HasFactory;
    public $table ="miniapp_data";

    function getMiniAppByMiniAppNameOrId($miniAppNameOrId){
        return MiniAppData::where('name',$miniAppNameOrId)->orWhere('id',$miniAppNameOrId)->first();
    }

    public function getAllMiniApps(){
        return MiniAppData::all();
    }

    public function getMiniAppByCategoryID($miniapp_category_id){
        return MiniAppData::where('miniapp_category_id', $miniapp_category_id)
        ->where('status', 1)
        ->get();
    }
}
