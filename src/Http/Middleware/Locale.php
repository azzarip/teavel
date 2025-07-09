<?php

namespace Azzarip\Teavel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Locale
{
    public function handle(Request $request, Closure $next, ?string $forcedLocale = null): Response
    {
        $supported = config('teavel.supported_locales', []);

        if ($forcedLocale) {
            if (!in_array($forcedLocale, $supported)) {
                throw new HttpException(400, "Locale '{$forcedLocale}' is not supported.");
            }

            app()->setLocale($forcedLocale);
            Cookie::queue('lang', $forcedLocale);
            return $next($request);
        }

        $locale = $request->cookie('lang');

        if ($locale) {
            if(in_array($locale, $supported)) {
                app()->setLocale($locale);
            } else {
                Cookie::queue(Cookie::forget('lang'));
            }
        }

        return $next($request);
    }
}