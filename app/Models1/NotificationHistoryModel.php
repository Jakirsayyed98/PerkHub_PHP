<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationHistoryModel extends Model
{
    use HasFactory;
    public $table ="notification_history";

    public static function getNotificationHistory($userId){
        return self::where('userId', $userId)->orderBy('created_at', 'desc')->get();
    }

}
