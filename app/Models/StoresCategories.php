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
        return self::all();
    }

}
