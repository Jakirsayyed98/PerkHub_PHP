<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller
{
    public function adminnotificationlist(Request $request)
    {
        $notificationList = Notifications::findAllNotifications();
        return view('adminpanel.notifications.customenotificationlist', compact('notificationList'));
    }

    public function CreateNotificationAndUpdate(Request $request)
    {
        $notification = $request->id ? Notifications::findNotificationById($request->id) : null;
        return view('adminpanel.notifications.createandupdatenotification', compact('notification'));
    }

    public function deleteNotificationProcess(Request $request)
    {
        $result = Notifications::deleteNotification($request->id);
        if ($result) {
            return redirect()->route('admin.notification.list')->with('success', 'Notification deleted successfully.');
        }
        return redirect()->route('admin.notification.list')->with('error', 'Notification not found or could not be deleted.');
    }

    public function sendAdminNotifications(Request $request)
    {
        $notification = Notifications::findNotificationById($request->id);
        if ($notification) {
            $title = $notification->title;
            $description = $notification->message;
            $image = $notification->image ? asset('public/upload/images/' . $notification->image) : null;
            $token = "/topics/all/";
            $this->sendNotification($token, $title, $description, $image, "1", "0");
            return redirect()->route('admin.notification.list')->with('success', 'Notification sent successfully.');
        }
        return redirect()->route('admin.notification.list')->with('error', 'Notification not found.');
    }

    public function createandupdatenotificationprocess(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:notifications,id',
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'click_action' => 'nullable|string|max:255',
            'type' => 'nullable|in:global,user_specific',
            'is_read' => 'nullable|boolean',
            'status' => 'nullable|boolean', // Added to match migration
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('upload/images'), $filename);
            $validated['image'] = $filename;
        } elseif (isset($validated['image']) && is_string($validated['image'])) {
            // Preserve existing image if no new file is uploaded
            $validated['image'] = basename($validated['image']);
        } else {
            $validated['image'] = null;
        }

        try {
            $result = Notifications::addOrUpdateNotification($validated);

            if (!$result) {
                Log::error('Notification updateOrCreate failed.', ['data' => $validated]);
                return back()->with('error', 'Notification could not be saved.');
            }

            return redirect()->route('admin.notification.list')->with('success', 'Notification saved successfully.');
        } catch (\Exception $e) {
            Log::error('Exception in notification process', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}