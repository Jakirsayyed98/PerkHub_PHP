<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Notification;
use App\Models\FcmToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $type = $request->input('type');
        $isRead = $request->input('is_read');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Notification::where(function ($query) use ($request) {
            $query->where('user_id', Auth::id())
                  ->orWhereNull('user_id');
        });

        if ($type) {
            $query->where('type', $type);
        }

        if ($isRead !== null) {
            $query->where('is_read', $isRead);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $notifications = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return ApiResponse::success(
            $notifications,
            'Notifications retrieved successfully'
        );
    }

    public function show(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhereNull('user_id');
            })
            ->first();

        if (!$notification) {
            return ApiResponse::error(
                'Notification not found or not authorized',
                [],
                404,
                'NOTIFICATION_NOT_FOUND'
            );
        }

        return ApiResponse::success(
            $notification,
            'Notification retrieved successfully'
        );
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhereNull('user_id');
            })
            ->first();

        if (!$notification) {
            return ApiResponse::error(
                'Notification not found or not authorized',
                [],
                404,
                'NOTIFICATION_NOT_FOUND'
            );
        }

        $notification->update(['is_read' => true]);

        return ApiResponse::success(
            $notification,
            'Notification marked as read'
        );
    }

    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->orWhereNull('user_id')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return ApiResponse::success(
            [],
            'All notifications marked as read'
        );
    }

    public function storeFcmToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'device_type' => 'nullable|string|in:android,ios',
            'device_id' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validation failed',
                $validator->errors(),
                422,
                'VALIDATION_FAILED'
            );
        }

        $token = FcmToken::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'token' => $request->token,
            ],
            [
                'device_type' => $request->device_type,
                'device_id' => $request->device_id,
            ]
        );

        return ApiResponse::success(
            $token,
            'FCM token stored successfully'
        );
    }
}