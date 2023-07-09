<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class CheckApiAccess
{
    public function handle($request, Closure $next)
    {
        if (!$request->bearerToken()) {
            return response()->json(['error' => 'Token not found'], 401);
        }

        return $next($request);
    }
}
