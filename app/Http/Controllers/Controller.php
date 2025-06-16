<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\notification_history_model;
use GuzzleHttp\Client;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function SendSuccessResponse($errorCode, $errorMsg, $result){
        $response = [
            'errorCode' => $errorCode,
            'errorMsg' => $errorMsg,
            'status'=>200,
        ];
        if ($result != null) {
            $response['data'] = $result;
        }
        return response()->json($response,200);
    }

    public function SendErrorResponse($errorCode, $errorMsg, $result){
        $response = [
            'errorCode' => $errorCode,
            'errorMsg' => $errorMsg,
            'status'=>400,
        ];
        if ($result != null) {
            $response['data'] = $result;
        }
        return response()->json($response,200);
    }

    public function sendResponse($errorCode,$result,$message){
        $response =[
            'errorCode'=>$errorCode,
            'errorMsg'=>$message,
            'data'=>$result,
            "status"=>200,
        ];
        return response()->json($response,200);
    }

    public function compress($source_image, $compress_image)
    {
        $image_info = getimagesize($source_image);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 20);             //for jpeg or gif, it should be 0-100
        } elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 3);
        }
        return $compress_image;
    }


    public function send(){
        $firebase = (new Factory)->withServiceAccount(__DIR__.'/../../config/firebase_credentials.json');
        $messaging = $firebase->createMessaging();
 
        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => 'Hello from Firebase!',
                'body' => 'This is a test notification.'
            ],
            'topic' => 'global'
        ]);
 
        $messaging->send($message);
 
        return response()->json(['message' => 'Push notification sent successfully']);
    }


    public function sendNotification($token,$title,$body,$image,$type,$userID){
        $apiURL = 'https://fcm.googleapis.com/v1/projects/perkhub-319e4/messages:send';
        $postInput = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'image' => $image
                ]
            ]  
        ];     
        $headers = [
            'Authorization' => 'Bearer ya29.a0AXooCgvMg0Z27t7O1Z7GhHCO0npS1QihUmpMecZQkBXy-aUhO1_nYr5BwPg1gW1zIOoRYS4qYNcWVYnZa27ikeUo1miK_xm0j6LQ7UmDGGeADQfT92iLRcl2yr3ia5dAm78AB3l_XOVO8cc_Q_yr6VVUUQEWFOnlidYRaCgYKAbASAQ8SFQHGX2MiMPUtA32sg1RSqSQcXQH81w0171',
            'Content-Type' => 'application/json',
        ];
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        
        // return $responseBody;
        $notificationmodel = new notification_history_model;
        $notificationmodel->type = $type;
        $notificationmodel->userID = $userID;
        $notificationmodel->title = $title;
        $notificationmodel->description = $body;
        $notificationmodel->icon = $image;
        $notificationmodel->image = $image;

        $notificationmodel->save();
        if($response){
            $response = [$responseBody];
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Error');
        }
    }

    public function printRawData($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;
    }



    function JWTEncoded($payload,$private_key,$alg) {
            // Define header and payload (claims)
        $header = [
            'typ' => 'JWT',
            'alg' => $alg
        ];

        $payload = $payload;

        // Encode header and payload as base64url strings
        $encodedHeader = base64_encode(json_encode($header));
        $encodedPayload = base64_encode(json_encode($payload));

        // Create signature
        $signature = hash_hmac('sha256', $encodedHeader . '.' . $encodedPayload, $private_key, true);
        $encodedSignature = base64_encode($signature);

        // Create JWT
        $jwt = $encodedHeader . '.' . $encodedPayload . '.' . $encodedSignature;

        return $jwt;
    }

    function imageSave(Request $req) {
        if ($req->hasFile('image')) {
            echo "image";
            return $this->saveOnPath($req->file('image'),"image");
        } else if ($req->hasFile('icon')) {
            echo "icon";
            return $this->saveOnPath($req->file('icon'),"icon");
        } else if ($req->hasFile('logo')) {
            echo "logo";
            return $this->saveOnPath($req->file('logo'),"logo");
        } else if ($req->hasFile('banner')) {
            echo "banner";
            return $this->saveOnPath($req->file('banner'),"banner");
        } else {
            return 'No image file uploaded';
        }
    }

    // function saveOnPath($file,$name){
    //     $extension = $file->getClientOriginalExtension();
    //     $filename = time().$name . "." . $extension;
    //     $file->move(public_path('upload/images'), $filename);
        
    //     return $filename;
    // }

    public function saveOnPath($file, $name){
        print_r($file);

        try {
            // Validate if the file is valid
            if (!$file->isValid()) {
                "";
            }

            $extension = $file->getClientOriginalExtension();
            $filename = time() . $name . "." . $extension;
            $file->move(public_path('upload/images'), $filename);

            return $filename;
        } catch (\Exception $e) {
            // Log the error message for debugging
            echo 'File upload error: ' . $e->getMessage();
            return "";
        }
    }

    function getImageWithUrl($image){
        // return asset('upload/images/'.$image);
        return "https://blessed-pretty-mammal.ngrok-free.app/upload/images/" . $image;
    }


    function generateRandomUUID($length = 20){
      
        // Generate 16 bytes (128-bit) UUID-like binary string
        $uuid = random_bytes(16);

        // Set version to 0100 (UUIDv4)
        $uuid[6] = chr((ord($uuid[6]) & 0x0f) | 0x40);
        // Set variant to 10xxxxxx
        $uuid[8] = chr((ord($uuid[8]) & 0x3f) | 0x80);

        // Format it to standard UUID string
        $uuidString = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($uuid), 4));

        // Trim or pad to desired length
        if (strlen($uuidString) >= $length) {
            return substr($uuidString, 0, $length);
        }

        return str_pad($uuidString, $length, '0');
    }


}
