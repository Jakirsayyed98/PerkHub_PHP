<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\OtpLog;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|string|min:10|max:15']);
        $mobile = $request->mobile;
        $otp = rand(100000, 999999);

        OtpLog::create([
            'mobile' => $mobile,
            'otp' => $otp,
            'status' => 'pending',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'expires_at' => now()->addMinutes(10),
        ]);

        // Simulate sending OTP (replace with actual SMS gateway)
        return ApiResponse::success('null', 'OTP sent successfully');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string|min:10|max:15',
            'otp' => 'required|string|size:6',
        ]);

        $otpLog = OtpLog::where('mobile', $request->mobile)
            ->where('otp', $request->otp)
            ->where('status', 'pending')
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otpLog) {
            return ApiResponse::error('Invalid or expired OTP', [], 400);
        }

        $otpLog->update(['status' => 'verified']);

        $user = User::where('mobile', $request->mobile)->first();
        
        if (!$user) {
            $user = User::create([
                'uuid' => Str::uuid(),
                'mobile' => $request->mobile,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return ApiResponse::success([
            'token' => $token,
            'is_new_user' => $user->name === null || $user->email === null || $user->gender === null || $user->dob === null,
        ], 'OTP verified');
    }

    public function updatePersonalInfo(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date|before:today',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ]);

        return ApiResponse::success($user, 'Personal info updated');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success(null, 'Logged out');
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        return ApiResponse::success(['token' => $token], 'Token refreshed');
    }
}