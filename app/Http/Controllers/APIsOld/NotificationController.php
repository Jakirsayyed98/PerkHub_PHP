<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationHistoryModel;
use Validator;
use App\Models\UserModel;


class NotificationController extends Controller
{
    //
    function getNotificationList(Request $req){
       $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
    
        $user = (new UserModel)->getUserByUserId($user_id);
        if($user->count()>0){
            $notification =(new NotificationHistoryModel)->getNotificationHistory($user_id);
            if($notification->count()>0){
                return $this->sendResponse('0',$notification,'Successfully');
            }
            return $this->sendResponse('1',[],'No Notification Found');
        }
        
        return $this->sendResponse('1',[],'Error');
    }



public function sendFcmNotification($deviceToken, $title, $body, $data = [])
{
    $serverKey = env('FCM_SERVER_KEY');
    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    $notification = [
        'title' => $title,
        'body'  => $body,
        'sound' => 'default',
    ];

    $payload = [
        'to' => $deviceToken,
        'notification' => $notification,
        'data' => $data, // optional custom payload
        'priority' => 'high',
    ];

    $response = Http::withHeaders([
        'Authorization' => 'key=' . $serverKey,
        'Content-Type' => 'application/json',
    ])->post($fcmUrl, $payload);

    return $response->json();
}


}
