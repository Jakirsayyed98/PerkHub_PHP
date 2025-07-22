<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class games_categories extends Model
{
    use HasFactory;

    public $table ="games_categories";

    function GetCategoryByCategoryId($id){
        return games_categories::where('id',$id)->first();
    }

    function GetCategoryByCategoryName($name){
        return games_categories::where('name',$name)->first();
    }

    function SaveGameCategory($name){
            $category = new games_categories;
            $category->name = $name;
            $category->save();
            return $category->id;
    }

}
