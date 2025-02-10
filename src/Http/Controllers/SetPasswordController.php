<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Http\Requests\LoginRequest;
use Azzarip\Teavel\Models\AuthToken;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SetPasswordController extends Controller
{
    use ValidatesRequests;

    public function internal(LoginRequest $request)
    {
        $contact = $this->processRequest($request);

        Auth::login($contact, true);
        session()->regenerate();

        if (session()->has('url.intended')) {
            return redirect(session('url.intended'));
        }

        return redirect()->route('my');
    }

    public function external(LoginRequest $request)
    {
        $contact = $this->processRequest($request);

        $token = AuthToken::generate($contact);

        return to_route('login.token', ['token' => $token]);
    }

    protected function processRequest(LoginRequest $request)
    {
        $validated = $request->validated();

        $contact = Contact::findEmail($validated['email']);

        if (! $contact) {
            abort(403);
        }

        if ($contact->isRegistered) {
            abort(403);
        }

        $contact->forceFill([
            'password' => Hash::make($validated['password']),
        ])->setRememberToken(Str::random(60));
        $contact->save();

        return $contact;
    }
}
