<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateProvider extends Model
{
    protected $table = 'affiliate_providers';
    protected $fillable = ['name', 'callback_secret'];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }

    public static function getActiveProviders()
    {
        return self::where('status', 'active')->get();
    }
}