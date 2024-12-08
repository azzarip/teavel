<?php

namespace Azzarip\Teavel\Actions\Forms;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SafeFormComplete 
{
    public static function complete(string $form, string $slug)
    {
        $contact = Auth::check() ? Auth::user() : Contact::find(Session::get('contact'));

        if ($contact && !Session::has($slug . '.form')) {
            $contact->completeForm($form);
            Session::put($slug . '.form', true);
        }
    }
}