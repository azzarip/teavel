<?php

namespace Azzarip\Teavel\Actions\Contact;

use Azzarip\Teavel\Models\Contact;

class Login
{
    public static function login(Contact $contact)
    {
        auth()->login($contact, remember: true);
        session()->remove('contact');
        request()->session()->regenerate();
    }
}
