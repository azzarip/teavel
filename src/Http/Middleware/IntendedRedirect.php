<?php

namespace Azzarip\Teavel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class IntendedRedirect
{
    public function handle(Request $request, Closure $next): Response
    {        
        if(Auth::guest()) {
            Session::put('url.intended', $request->url());
        }

        return $next($request);
    }
}
