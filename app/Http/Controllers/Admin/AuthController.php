<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt', $request->only('email'));
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->guard('admin')->attempt($credentials)) {
            $user = auth()->guard('admin')->user();
            Log::info('Login successful', ['user_id' => $user->id]);
            $token = $user->createToken('admin-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'data' => ['token' => $token],
                'message' => 'Login successful',
            ]);
        }

        Log::error('Login failed', $request->only('email'));
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }
    public function dashboard()
{
    return view('admin.dashboard');
}
}