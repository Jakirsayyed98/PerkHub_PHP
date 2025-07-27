<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AffiliateProvider;
use App\Helpers\ApiResponse;

class CallbackValidate
{
    public function handle(Request $request, Closure $next)
    {
        $secret = $request->header('X-Cuelinks-Secret');
        $provider = AffiliateProvider::where('name', 'cuelinks')->first();

        if (!$provider || $provider->callback_secret !== $secret) {
            return ApiResponse::error('Invalid callback secret', [], 401, 'INVALID_CALLBACK_SECRET');
        }

        return $next($request);
    }
}