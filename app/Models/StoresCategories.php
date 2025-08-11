<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoresCategories extends Model
{
    use HasFactory;
    public $table = "stores_categories";
    protected $fillable = [
        'name', 'description', 'image', 'status', 'homepage_visible'
    ];

    public function getAllCategories()
    {
        return self::where('status', true)->get()->map(function ($category) {
                    $category->image = $category->image ? url('upload/images/' . $category->image) : null;
                    return $category;
                });
    }

    public function getAllHomepageVisibleCategories()
    {
        return self::where('homepage_visible', true)->orWhere('status',true)->get();
    }
}
