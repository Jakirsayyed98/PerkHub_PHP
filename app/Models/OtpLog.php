<?php

// app/Models/OtpLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpLog extends Model
{
    protected $fillable = [
        'mobile',
        'otp',
        'status',
        'ip_address',
        'user_agent',
    ];

    public static function generateOtp($mobile, $otp, $ip, $userAgent)
{
    return self::create([
        'mobile' => $mobile,
        'otp' => $otp,
        'status' => 'sent',
        'ip_address' => $ip,
        'user_agent' => $userAgent,
    ]);
}


public static function validateOtp($mobile, $otp)
{
    return self::where('mobile', $mobile)
        ->where('otp', $otp)
        ->where('status', 'sent')
        ->orderByDesc('id')
        ->first();
}

public static function getLastVerifiedOtp($mobile)
{
    return self::where('mobile', $mobile)
        ->where('status', 'verified')
        ->orderByDesc('id')
        ->first();
}


}
