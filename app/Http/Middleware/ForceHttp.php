<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttp
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->secure() && app()->environment('local')) {
            return redirect()->to($request->getRequestUri(), 302, [], false);
        }
        return $next($request);
    }
}