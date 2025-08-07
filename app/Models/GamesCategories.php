<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamesCategories extends Model
{
    use HasFactory;
    
    public static function getAllGameCategories()
    {
        return self::all();
    }

    public static function GetCategoryByCategoryName($categoryName)
    {
        return self::where('name', $categoryName)->first();
    }

    

}
