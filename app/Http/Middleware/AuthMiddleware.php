<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->routeIs('register') || $request->routeIs('login') || $request->routeIs('logout')) {
            if (Auth::check()) {
                return response()->json(['error' => 'Already authenticated'], 403);
            }
        }

        return $next($request);
    }
}
