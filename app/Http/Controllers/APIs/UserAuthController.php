<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class UserAuthController extends Controller
{
    //



    function sendOTPtoUser(Request $req) {

        $data = json_decode($req->getContent());
        if (Str::length($data->number)<10 && Str::length($data->number)>10){
            return $this->SendErrorResponse('01',"please check entered mobile number",'');
        }

        $user = UserModel::where('number',$data->number)->first();
        $digits = 5;

        
        $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
        if(!$user){
            $user = new UserModel();
            $user->number =$data->number;
            $user->otp = $otp;
            $user->user_id = $this->generateRandomUUID(16);
            $user->save();
        }else{
            $user->otp = $otp;
            $user->save();
        }
        return $this->SendSuccessResponse('00','OTP sent successfully','');
    }

    function generateUserId($length = 13) {
         // Define possible characters for alphanumeric generation
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $charactersLength = strlen($characters);
            $userId = '';
            
            // Generate alphanumeric string
            for ($i = 0; $i < $length; $i++) {
                $userId .= $characters[random_int(0, $charactersLength - 1)];
            }

            // Insert a hyphen every 5 characters
            $formattedUserId = '';
            for ($i = 0; $i < strlen($userId); $i++) {
                // Add a hyphen after every 5th character (except at the end)
                if ($i > 0 && $i % 6 == 0) {
                    $formattedUserId .= '-';
                }
                $formattedUserId .= $userId[$i];
            }

            return $formattedUserId;
    }

    function authorization(Request $req) {
        $request = json_decode($req->getContent());
        $number  = $request->number;
        
        $token = $this->GenerateJWTToken($number);
        if ($token) {
            return $this->SendSuccessResponse('00','Token generated successfully',$token);
        } else {
            return $this->SendErrorResponse('01','Error generating token','');
        }
    }

    function verifyOTP(Request $req){
        $request = json_decode($req->getContent());
        $number = $request->number;
        $otp = $request->otp;
        if(Str::length($otp)==5){
        $user = UserModel::where('number',$number)->where('otp', $otp)->first();
        if($user){
            $user->status = true;
            $user->save();

            $token = $this->GenerateJWTToken($number);
            if (!$token) {
                return $this->SendErrorResponse('01','Error generating token','');
            }
            
            

            return $this->SendSuccessResponse('00','OTP verified successfully',$token);
        }else{
            return $this->SendErrorResponse('01','Invalid OTP','');
        }
        }else{
            return $this->SendErrorResponse('01','Invalid OTP','');
        }
    }

    function saveUserdetail(Request $request){
        $req = json_decode($request->getContent());
        $userId = $request->attributes->get('user_id');
        $user = UserModel::where('user_id',$userId )->first();
        if(!$user){
            return $this->SendErrorResponse('01','User not found','');
        }
      
        $user->name = $req->name;
        $user->email = $req->email;
        $user->dob = $req->dob;

      $user->save();

        if($user){
            return $this->SendSuccessResponse('00','Detail saved successfully',"");
        }else{
            return $this->SendErrorResponse('01','Error while saving details','');
        }
       
    }

    function updateNotificationToken(Request $req){
        $request = json_decode($req->getContent());
        $fcm_token = $request->fcm_token;
        $userId = $req->attributes->get('user_id');
        $user = UserModel::where('user_id',$userId )->first();
        if(!$user){
            return $this->SendErrorResponse('01','User not found','');
        }

        $user->FCMtoken =$fcm_token;
        $user->save();
        
        if($user){
            return $this->SendSuccessResponse('00','Token updated successfully','');
        }else{
            return $this->SendErrorResponse('01','Error while updating token','');
        }
    }

    function getUserDetails(Request $req) {
        $user_id = $req->attributes->get('user_id');
        $result = UserModel::where('user_id',$user_id )->get();
        if($result){
            $response = $result;
            return $this->SendSuccessResponse('0','Successfully got user details',$response);
        }else{
        
            $response = [];
            return $this->SendErrorResponse('1','Error while getting user details',null);
        }
    }

    function GenerateJWTToken($number){
        // Check if the user exists
        $user = UserModel::where('number', $number)->first();

        if (!$user) {
            return 'user not found';
        }
    
        // Set expiration time for the token (e.g., 1 hour)
        $expiration = Carbon::now()->addYear();  // You can change the duration here
        
        $customClaims = [
            'iss' => 'perkhub',  // Issuer is set to "perkhub"
            'exp' => $expiration->timestamp,  // Expiration time in Unix timestamp
            'sub' => $user->user_id,  // Subject is the user_id of the user
            'prv' => md5($user->user_id)  // Example: Private claim, here using an MD5 hash of user_id (you can customize this)
        ];

        // Create the token with only custom claims, excluding the default ones like iat, nbf, jti
        try {
            $token = JWTAuth::customClaims($customClaims)->fromUser($user);
        } catch (\Exception $e) {
        return $e->getMessage();
        }
        // Return the token and expiration time in the response
        return $token;
    }
}