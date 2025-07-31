<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_notification_model;

class NotificationsController extends Controller
{
    
    function adminnotificationlist(Request $req){
        $notificationList = admin_notification_model::all();
        return view('adminpanel/notifications/customenotificationlist',['notificationList'=>$notificationList]);
    }

    function CreateNotificationAndUpdate(Request $req){
        $notificationList = admin_notification_model::find($req->id);
        return view('adminpanel/notifications/createandupdatenotification',['notificationList'=>$notificationList]);
    }

    function deleteNotificationProcess(Request $req){
        $notificationList = admin_notification_model::where('id',$req->id)->delete();
        return redirect('adminnotificationlist');
    }

    function sendAdminNotifications(Request $req){
        $notificationList = admin_notification_model::find($req->id);
        $title = $notificationList->title;
        $description = $notificationList->description;
        $icon = asset('public/upload/images/'.$notificationList->icon);
        $image = asset('public/upload/images/'.$notificationList->image);
        $token = "/topics/all/";
        $this->sendNotification($token,$title,$description,$image,"1","0");

        return redirect('adminnotificationlist');
    }

    function createandupdatenotificationprocess(Request $req){
        $title = $req->name;
        $description = $req->description;
        $id = $req->id;

        $data = admin_notification_model::find($id);
        if(is_null($data)){
            $notificationModel =new admin_notification_model;
        }else{
            $notificationModel = admin_notification_model::find($id);
        }

        $notificationModel->title = $title;
        $notificationModel->description = $description;


        if($req->hasfile('icon')){
            $file = $req->file('icon');
            $extention = $file->getClientOriginalExtension();
            $filename = time()."icon".".".$extention;
            $file->move('public/upload/images/',$filename);
            $notificationModel->icon =$filename;
        }

        if($req->hasfile('image')){
            $file = $req->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time()."image".".".$extention;
            $file->move('public/upload/images/',$filename);
            $notificationModel->image =$filename;
        }
        $notificationModel->save();

        return redirect('adminnotificationlist');
        
    }

}
