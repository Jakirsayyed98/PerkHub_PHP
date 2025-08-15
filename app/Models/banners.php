<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banners extends Model
{
    use HasFactory;
    public $table ="banners";
    
    public function getBannerByBannerCategoryId($categoryId)
    {
        return self::where('banner_category_id', $categoryId)->where('status', true)->
        get()->
        map(function ($banner) {
                    $banner->image = $banner->image ? url('upload/images/' . $banner->image) : null;
                    return $banner;
                });
    }
}
