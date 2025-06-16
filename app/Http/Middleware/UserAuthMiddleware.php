<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $controller = app(Controller::class);
        if (!$token) {
            
            return $controller->SendErrorResponse('01', 'Authorization token not found', null);
        }
        list($data, $valid) = $this->getUserIdFromToken($token);

        if (!$valid) {
            return $controller->SendErrorResponse('01', $data, null);
        }
        $request->attributes->add(['user_id' => $data]);
        return $next($request);
    }
    
    function getUserIdFromToken($token){
        try {
            // Decode the JWT token and get the claims
            $decoded = JWTAuth::setToken($token)->getPayload();            
            // Extract the 'sub' claim, which represents the user_id
            $userId = $decoded['sub'];
            
            return [$userId,true];
        } catch (TokenExpiredException $e) {
            return ["Token has expired",false];
        } catch (TokenInvalidException $e) {
            return ["Token is invalid",false];
        } catch (JWTException $e) {
            return [ $e->getMessage(),false];
        }
    }
}
