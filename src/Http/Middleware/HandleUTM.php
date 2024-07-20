<?php

namespace Azzarip\Teavel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleUTM
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->has('utm_source')){
            $request->session()->put('utm.source', $request->get('utm_source'));
            $request->session()->put('utm.medium', $request->get('utm_medium'));
            $request->session()->put('utm.campaign', $request->get('utm_campaign'));
            $request->session()->put('utm.content', $request->get('utm_content'));
            $request->session()->put('utm.term', $request->get('utm_term'));

            if($request->has('gclid') && $request->get('utm_source') == 'google'){
                $request->session()->put('utm.click_id', $request->get('gclid'));
            }

            return $next($request);
        }

        if($request->has('gclid')) {
            $request->session()->put('utm.source', 'google');
            $request->session()->put('utm.medium', 'cpc');
            $request->session()->put('utm.click_id', $request->get('gclid'));
            return $next($request);
        }

        return $next($request);
    }
}
