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
            'expires_at' => now()->addMinutes(10),
        ]);

        // Simulate sending OTP (replace with actual SMS gateway)
        \Log::info("OTP $otp sent to $mobile");

        return ApiResponse::success('OTP sent', ['mobile' => $mobile]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string|min:10|max:15',
            'otp' => 'required|string|size:6',
        ]);

        $otpLog = OtpLog::where('mobile', $request->mobile)
            ->where('otp', $request->otp)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otpLog) {
            return ApiResponse::error('Invalid or expired OTP', [], 400);
        }

        $user = User::where('mobile', $request->mobile)->first();
        
        if (!$user) {
            $user = User::create([
                'uuid' => Str::uuid(),
                'mobile' => $request->mobile,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return ApiResponse::success('OTP verified', [
            'token' => $token,
            'is_new_user' => is_null($user->name) || is_null($user->email),
        ]);
    }

    public function updatePersonalInfo(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return ApiResponse::success('Personal info updated', $user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success('Logged out');
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        return ApiResponse::success('Token refreshed', ['token' => $token]);
    }
}