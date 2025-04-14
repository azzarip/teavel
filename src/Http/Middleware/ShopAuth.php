<?php

namespace Azzarip\Teavel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ShopAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $segments = $request->segments();

        if (count($segments) >= 2 && Auth::guest()) {
            return redirect()->to(url($segments[0] . '/' . $segments[1]));
        }

        return $next($request);
    }
}
