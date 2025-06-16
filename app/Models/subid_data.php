<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subid_data extends Model
{
    use HasFactory;
    public $table = 'miniappsubiddata';
    protected $fillable = [
        'user_id',
        'brand_name',
        'brand_id',
        'subid1',
    ];

    // function InsertSubId($user_id, $brand_id, $subid1){
    //     $user = new UserModel();

    //     $user->user_id = $user_id;
    //     $user->brand_id = $brand_id;
    //     $user->subid1 = $subid1;
    //     return $user->save();
    // }
    public static function InsertSubId($user_id, $brand_id, $subid1)
    {
        return self::create([
            'user_id' => $user_id,
            'brand_id' => $brand_id,
            'subid1' => $subid1,
        ]);
    }

    public static function getDataBySubId($subid1)
    {
        return self::where('subid1', $subid1)->first();
    }
}
