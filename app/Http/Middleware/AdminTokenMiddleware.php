<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AdminTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = session('admin_token');

        if (!$token) {
            return redirect()->route('admin.login');
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken || !$accessToken->tokenable) {
            session()->forget('admin_token');
            return redirect()->route('admin.login');
        }

        // ✅ Log in the user from token
        Auth::login($accessToken->tokenable);

        return $next($request);
    }
}
