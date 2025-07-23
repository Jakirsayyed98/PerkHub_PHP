<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    protected $fillable = ['store_id', 'user_id', 'subid', 'subid2', 'clicked_at'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function logClick($storeId, $userId, $subid1, $subid2)
    {
        return self::create([
            'store_id' => $storeId,
            'user_id' => $userId,
            'subid' => $subid1,
            'subid2' => $subid2,
            'clicked_at' => now(),
        ]);
    }
}