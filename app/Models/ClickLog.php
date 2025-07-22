<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    protected $fillable = ['store_id', 'user_id', 'subid', 'subid2', 'clicked_at'];
}
