<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Exceptions\RegistrationException;
use Azzarip\Teavel\Http\Requests\FullRegistrationRequest;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FullRegistrationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(FullRegistrationRequest $request)
    {
        $data = $request->validated();

        try {
            $contact = Contact::register($data);
        } catch (RegistrationException $e) {
            return redirect(route('login'))
                ->withInput($request->only('email'))
                ->withErrors(['user' => 'already_registered']);
        }

        Auth::login($contact, true);
        session()->regenerate();

        if (config('teavel.post_register')) {
            config('teavel.post_register')::handle($contact);
        }

        if (session()->has('url.intended')) {
            return redirect(session('url.intended'));
        }

        return redirect('/');
    }
}
