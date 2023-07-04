<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response = response($response);
        $response->header('Access-Control-Allow-Origin', 'http://localhost:4200');
        $response->header('Access-Control-Allow-Methods', '*');
        $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Allow-Headers', 'X-CSRF-Token');
        return $response;
    }
}
