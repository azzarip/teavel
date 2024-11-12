<?php

namespace Azzarip\Teavel\Http\Controllers;

use Illuminate\Http\Request;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Routing\Controller;
use Azzarip\Teavel\Models\AuthToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TokenLoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $token)
    {
        $contact = AuthToken::find($token);

        if( ! $contact) {
            return to_route('my');
        }

        Auth::login($contact, true);
        session()->regenerate();

        return to_route('my');
    }
}
