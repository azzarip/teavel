<?php

namespace Azzarip\Teavel\Locale;

use Illuminate\Support\Facades\Cookie;

class SetCookie
{

    /**
     * Set the locale cookie.
     *
     * @param string $locale
     * @return void
     */
    public static function locale(string $locale): void
    {
        Cookie::queue(Cookie::make('lang', $locale, 60 * 24 * 365, httpOnly: false));
    }
}