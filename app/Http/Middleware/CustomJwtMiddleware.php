<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ApiResponse;

class CustomJwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return ApiResponse::error(
                'Token has expired',
                [],
                401,
                'TOKEN_EXPIRED'
            );
        } catch (TokenInvalidException $e) {
            return ApiResponse::error(
                'Token is invalid',
                [],
                401,
                'TOKEN_INVALID'
            );
        } catch (JWTException $e) {
            return ApiResponse::error(
                'Token is missing',
                [],
                401,
                'TOKEN_MISSING'
            );
        }

        return $next($request);
    }
}
