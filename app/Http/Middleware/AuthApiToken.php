<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('Authorization');

        if ($key == null || str_replace('Bearer ', '', $key) !== env('API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
