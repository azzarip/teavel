<?php

namespace Azzarip\Teavel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultiForm {
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('contact') || Auth::check()) {
            return $next($request);
        }

        $segments = $request->segments();

        if (count($segments) >= 2) {
            array_pop($segments); // remove the last segment
            $redirectTo = '/' . implode('/', $segments);
            return redirect($redirectTo);
        }
        return $next($request);
    }
}