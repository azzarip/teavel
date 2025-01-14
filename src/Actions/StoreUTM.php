<?php

namespace Azzarip\Teavel\Actions;

use Illuminate\Support\Str;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class StoreUTM 
{
    public static function store(?array $data)
    {
        if($data === []) return;

        if(Session::has('utm')) {
            $key = Session::get('utm');
        } else {
            $key = (string) Str::uuid();
            Session::put('utm', $key);
        }

        Cache::put($key, $data, 120 * 60);

    }
}