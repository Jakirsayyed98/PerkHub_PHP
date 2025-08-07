<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Notification;
use App\Models\FcmToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');
        $type = $request->input('type');

        $query = Notification::with(['user' => function ($query) {
            $query->select('id', 'name', 'email', 'mobile');
        }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($type) {
            $query->where('type', $type);
        }

        $notifications = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return ApiResponse::success($notifications, 'Notifications retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'type' => 'required|in:global,user_specific',
            'user_id' => 'required_if:type,user_specific|exists:users,id',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422, 'VALIDATION_FAILED');
        }

        $notification = Notification::create([
            'user_id' => $request->type === 'user_specific' ? $request->user_id : null,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
        ]);

        $tokens = $request->type === 'user_specific'
            ? FcmToken::where('user_id', $request->user_id)->pluck('token')
            : FcmToken::pluck('token');

        if ($tokens->isNotEmpty()) {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . env('FCM_SERVER_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'registration_ids' => $tokens->toArray(),
                'notification' => [
                    'title' => $request->title,
                    'body' => $request->message,
                ],
            ]);

            if ($response->failed()) {
                Log::error('FCM notification failed', ['error' => $response->body()]);
            }
        }

        return ApiResponse::success($notification, 'Notification sent successfully');
    }
}