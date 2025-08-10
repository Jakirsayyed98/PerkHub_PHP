<?php

namespace App\Helpers;

class ApiResponse
{
    // public static function success($data = [], $message = 'Success', $code = 200)
    // {
    //     return response()->json([
    //         'status'  => true,
    //         'message' => $message,
    //         'code'    => $code,
    //         'data'    => $data
    //     ], $code);
    // }

    // public static function error($message = 'Error', $errors = [], $code = 400, $errorCode = null)
    // {
    //     return response()->json([
    //         'status'     => false,
    //         'message'    => $message,
    //         'code'       => $code,
    //         'error_code' => $errorCode,
    //         'errors'     => $errors
    //     ], $code);
    // }

    public static function success($result, $errorMsg, $errorCode="00"){
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

    public static function error($errorMsg,$result,$errorCode  ){
        $response = [
            'errorCode' => "01",
            'errorMsg' => $errorMsg,
            'status'=>400,
        ];
        if ($result != null) {
            $response['data'] = $result;
        }
        return response()->json($response,200);
    }

}