<?php

namespace Azzarip\Teavel\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Azzarip\Teavel\Mail\Mailables\PasswordResetMail;
use Azzarip\Teavel\Mail\Mailables\PasswordRegisterMail;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PasswordController extends Controller
{
    use ValidatesRequests;

    public function reset(Request $request){
        $validated = $request->validate([
            'token' => 'required',
            'password' => 'required|min:8',
            'uuid' => 'required',
        ]);

        $contact = Contact::findUuid($validated['uuid']);

        $pass = Password::tokenExists($contact, $validated['token']);

        if(!$pass) {
            return redirect()->route('password.request')->withErrors(['token' => trans('teavel::auth.error.token')]);
        }

        $contact->forceFill([
            'password' => Hash::make($validated['password'])
        ])->setRememberToken(Str::random(60));
        $contact->save();

        Password::deleteToken($contact);

        return redirect()->route('login')
            ->with('info', trans('teavel::auth.status.reset'));
    }

    public function request(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $contact = Contact::findEmail($request['email']);

        $this->processRequest($contact);

        return redirect()->route('password.success');
    }

    protected function processRequest($contact)
    {
        if( ! $contact) return;

        if( ! $contact->is_registered) {
            Mail::send((new PasswordRegisterMail())->toContact($contact));
            return;
        }

        $token = Password::getRepository()->create($contact);

        Mail::send((new PasswordResetMail($token))->toContact($contact));

        return;
    }
}
