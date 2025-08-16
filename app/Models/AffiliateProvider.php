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
        return self::where('status', '1')->get();
    }

    public static function getAllProviders()
    {
        return self::all();
    }

    public static function DeleteAffiliateProvider($id)
    {
        return self::where('id', $id)->delete();
    }

    public static function getAffiliateProviderById($id)
    {
        return self::find($id);
    }

    public static function AffiliateStatusUpdate($id)
    {
        $provider = self::find($id);
        if ($provider) {
            $provider->status = ($provider->status == '1') ? '0' : '1';
            $provider->save();
        }
        return $provider;
    }

   public static function AffiliateAddOrUpdate($data){
        $id = $data['id'] ?? null; // avoid undefined index
        $affiliate = $id ? self::find($id) : null;

        if (is_null($affiliate)) {
            $affiliate = new self(); // or AffiliateProvider if outside class
            $affiliate->status = 1;  // use 1 instead of true if DB expects tinyint
        }

        $affiliate->name = $data['name'] ?? $affiliate->name;
        $affiliate->callback_secret = $data['callback_secret'] ?? $affiliate->callback_secret;
        $affiliate->base_url = $data['base_url'] ?? $affiliate->base_url;

        $affiliate->save();

        return $affiliate; // return the model instead of just bool
    }
}