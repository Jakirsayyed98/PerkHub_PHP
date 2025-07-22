<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'affiliate_source',
        'reference_id',
        'order_id',
        'transaction_date',
        'order_amount',
        'affiliate_commission',
        'user_commission',
        'user_commission_percent',
        'status',
        'subid', 'subid1', 'subid2', 'subid3',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
