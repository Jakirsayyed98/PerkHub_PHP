<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = [], $message = 'Success', $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'code'    => $code,
            'data'    => $data
        ], $code);
    }

    public static function error($message = 'Error', $errors = [], $code = 400, $errorCode = null)
    {
        return response()->json([
            'status'     => false,
            'message'    => $message,
            'code'       => $code,
            'error_code' => $errorCode, // 👈 Custom application error code
            'errors'     => $errors
        ], $code);
    }
}
