<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpLog extends Model
{
    protected $fillable = ['mobile', 'otp', 'status', 'ip', 'user_agent', 'created_at'];

    public static function generateOtp($mobile, $otp, $ip, $userAgent)
    {
        return self::create([
            'mobile' => $mobile,
            'otp' => $otp,
            'status' => 'pending',
            'ip' => $ip,
            'user_agent' => $userAgent,
            'created_at' => now(),
        ]);
    }

    public static function validateOtp($mobile, $otp)
    {
        return self::where('mobile', $mobile)
            ->where('otp', $otp)
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();
    }

    public function markAsVerified()
    {
        $this->update(['status' => 'verified']);
    }

    public static function hasVerifiedOtp($mobile)
    {
        return self::where('mobile', $mobile)
            ->where('status', 'verified')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->exists();
    }
}