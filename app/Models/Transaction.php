<?php
// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'store_id', 'affiliate_source', 'reference_id', 'order_id',
        'transaction_date', 'order_amount', 'affiliate_commission', 'user_commission',
        'user_commission_percent', 'status', 'subid', 'subid1', 'subid2', 'subid3'
    ];

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
