<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Models\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class TokenLoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $token)
    {
        $contact = AuthToken::redeem($token);

        if (! $contact) {
            return to_route('my');
        }

        Auth::login($contact, true);
        session()->regenerate();

        return to_route('my');
    }
}
