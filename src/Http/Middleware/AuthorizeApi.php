<?php

namespace Azzarip\Teavel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $username = $request->getUser();
            $password = $request->getPassword();
            if ($username != config('services.azzari-api.server_name') || $password != config('services.azzari-api.response_password')) {
                return response()->json(['error' => 'Authentication Error.'], 401);
            }
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Generic Server Error.'], 500);
        }
    }
}
