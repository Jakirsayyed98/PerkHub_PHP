<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offers extends Model
{
    use HasFactory;
    public $table  = 'offers';

    protected $fillable = [
        'title',
        'image',
        'end_date',
        'url',
        'coupon_code',
        'type',
        'terms',
        'miniapp_id',
        'status'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function getOfferPaginate($limit = 10) {
        return $this->paginate($limit);
    }

    function getOfferById($id) {
        return $this->where('id', $id)->first();
    }

    function deleteOfferById($id) {
        return $this->where('id', $id)->delete();
    }
    
}
