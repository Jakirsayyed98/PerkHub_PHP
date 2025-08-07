<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class UserAuthController extends Controller
{
    //

    function sendOTPtoUser(Request $req) {
        $number  = $req->number;
        
        $user = UserModel::where( 'number',$number )->first();
        $digits = 5;
        $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
      
        if(Str::length($number)<10){
            
                $response = [];
                return $this->sendResponse('1',$response,'please enter valid number');

        } else{

       
        if(!$user){
        $UserModel =new UserModel;
        $UserModel->number = $number;
        $UserModel->otp = "".$otp;
        $UserModel->save();

            $response = [$UserModel];
            return $this->sendResponse('0',$response,'New User Successfully');
       }else{
        $UserModel =new UserModel;
        $UserModel = $user;
        $UserModel->otp = "".$otp;
    
        $UserModel->save();
        

            $response = [$user];
            return $this->sendResponse('0',$response,'Sent Successfully');
       }
    }

    }

    function verifyOTP(Request $req){
        $number = $req->number;
        $otp = $req->otp;
        if(Str::length($otp)==5){

        

        $user = UserModel::where('number',$number )->first();
        if($user->otp==$otp){
            $UserModel =new UserModel;
            $UserModel = $user;
            $UserModel->status = "1";
            $UserModel->save();
            $user1 = UserModel::where('number',$number)->first();
        
            $response = [$user1];
            return $this->sendResponse('0',$response,'Verified Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Wrong OTP');
        }
    }else{
            $response = [];
            return $this->sendResponse('1',$response,'Wrong OTP');
    }

    }

    function saveUserdetail(Request $req){
        $name = $req->name;
        $number = $req->number;
        $email = $req->email;
        $gender = $req->gender;
        $user = UserModel::where('number',$number )->first();

        $userModel = new UserModel;
        $userModel = $user;
        $userModel->name =$name;
        $userModel->number =$number;
        $userModel->email =$email;
        $userModel->gender =$gender;
        $result = $userModel->save();

        if($result){
           

            $response = [$userModel];
            return $this->sendResponse('0',$response,'Successfully');

        }else{
        
            $response = [];
            return $this->sendResponse('1',$response,'Error');
        }
       
    }


    
    



}