<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'image',
        'click_action',
        'type',
        'is_read',
        'status',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'status' => 'boolean',
        'type' => 'string',
    ];

    public static function findAllNotifications()
    {
        return self::query()->orderByDesc('created_at')->get();
    }

    public static function findNotificationById($id)
    {
        return self::find($id);
    }

    public static function findAllNotificationsByUserId($userId)
    {
        return self::where('user_id', $userId)->orderByDesc('created_at')->get();
    }

    public static function addOrUpdateNotification($data)
    {
        try {
            $image = $data['image'] ?? null;
            if (!empty($image) && is_string($image) && strlen($image) < 1024) {
                $image = asset('public/upload/images/' . $image);
            } else {
                $image = null;
            }

            $notification = self::updateOrCreate(
                ['id' => $data['id'] ?? null],
                [
                    'user_id' => $data['user_id'] ?? null,
                    'title' => $data['title'] ?? '',
                    'message' => $data['message'] ?? '',
                    'image' => $image,
                    'click_action' => $data['click_action'] ?? null,
                    'type' => $data['type'] ?? 'global',
                    'is_read' => $data['is_read'] ?? false,
                    'status' => $data['status'] ?? true,
                ]
            );

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create/update notification', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public static function markActiveDeactiveNotification($notificationId, $isActive)
    {
        $notification = self::find($notificationId);
        if ($notification) {
            $notification->is_read = $isActive;
            $notification->save();
            return $notification;
        }
        return null;
    }

    public static function deleteNotification($id)
    {
        $notification = self::find($id);
        if ($notification) {
            return $notification->delete();
        }
        return false;
    }
}