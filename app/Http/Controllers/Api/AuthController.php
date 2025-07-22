<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OtpLog;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    /**
     * Step 1: Send OTP (Rate-limited)
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        // Rate limiting: 5 attempts per minute per mobile
        $key = 'send-otp:' . $request->mobile;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return ApiResponse::error(
                'Too many OTP requests. Try again later.',
                [],
                429,
                'RATE_LIMIT_EXCEEDED'
            );
        }

        $otp = rand(100000, 999999);
        OtpLog::generateOtp($request->mobile, $otp, $request->ip(), $request->userAgent());

        RateLimiter::hit($key, 60); // 60 seconds decay

        return ApiResponse::success([], 'OTP sent successfully');
    }

    /**
     * Step 2: Verify OTP and issue JWT token
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6'
        ]);

        $otpLog = OtpLog::validateOtp($request->mobile, $request->otp);

        if (!$otpLog) {
            return ApiResponse::error(
                'Invalid or expired OTP',
                [],
                401,
                'OTP_INVALID'
            );
        }

        // Mark OTP as verified
        $otpLog->markAsVerified();

        // Create or fetch user
        $user = User::findOrCreateByMobile($request->mobile);
        $token = $user->generateJwtToken();

        return ApiResponse::success([
            'token' => $token,
            'user' => $user
        ], 'Login successful');
    }

    /**
     * Step 3: Issue JWT token (refresh case, requires prior OTP verification)
     */
    public function issueToken(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        // Check if user has a verified OTP
        if (!OtpLog::hasVerifiedOtp($request->mobile)) {
            return ApiResponse::error(
                'No verified OTP found. Please verify OTP first.',
                [],
                401,
                'OTP_NOT_VERIFIED'
            );
        }

        $user = User::findByMobile($request->mobile);
        if (!$user) {
            return ApiResponse::error(
                'User not found',
                [],
                404,
                'USER_NOT_FOUND'
            );
        }

        $token = $user->generateJwtToken();

        return ApiResponse::success([
            'token' => $token,
            'user' => $user
        ], 'Token issued successfully');
    }

    /**
     * Step 4: Register (Traditional, per documentation)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'mobile' => 'required|digits:10|unique:users,mobile'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $request->password // Assume User::create handles bcrypt
        ]);

        $token = $user->generateJwtToken();

        return ApiResponse::success([
            'token' => $token,
            'user' => $user
        ], 'Registration successful');
    }

    /**
     * Step 5: Login (Traditional, per documentation)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ApiResponse::error(
                    'Invalid credentials',
                    [],
                    401,
                    'INVALID_CREDENTIALS'
                );
            }
        } catch (JWTException $e) {
            return ApiResponse::error(
                'Could not create token',
                [],
                500,
                'TOKEN_CREATION_FAILED'
            );
        }

        $user = JWTAuth::user();
        return ApiResponse::success([
            'token' => $token,
            'user' => $user
        ], 'Login successful');
    }

    /**
     * Step 6: Get authenticated user profile
     */
    public function profile(Request $request)
    {
        return ApiResponse::success($request->user(), 'User profile');
    }

    /**
     * Step 7: Logout and invalidate token
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return ApiResponse::success([], 'Logged out successfully');
        } catch (JWTException $e) {
            return ApiResponse::error('Token is invalid or expired', [], 400);
        }
    }
}