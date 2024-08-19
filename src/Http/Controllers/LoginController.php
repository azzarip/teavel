<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Azzarip\Teavel\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:255',
        ]);

        $contact = Contact::findEmail($request['email']);

        if(!$contact || !$contact->is_registered) {
            return redirect()
                        ->route('register')
                        ->withErrors(['user' => 'User not registered'])
                        ->withInput($request->only('email'));
        }

        if (! Hash::check($request['password'], $contact->password)) {
            return back()->withErrors(['user' => trans('teavel::auth.error.user')])
                ->withInput($request->only('email'));
        }

        Auth::login($contact, true);
        session()->regenerate();

        session()->has('url.intended');
        if (session()->has('url.intended')) {
            return redirect(session('url.intended'));
        }

        return redirect('/');
    }
}
