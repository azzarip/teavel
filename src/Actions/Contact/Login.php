<?php 

namespace Azzarip\Teavel\Actions\Contact;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Login 
{
    public static function login(Contact $contact) {
        Auth::login($contact, true);
        Session::remove('contact');
        Session::regenerate();
    }
}