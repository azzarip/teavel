<?php

namespace Azzarip\Teavel\Http\Controllers;

use Illuminate\Http\Request;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Azzarip\Teavel\Mail\Mailables\PasswordResetMail;
use Azzarip\Teavel\Mail\Mailables\PasswordRegisterMail;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PasswordController extends Controller
{
    use ValidatesRequests;

    public function update(Request $request){
        $validated = $request->validate([
            'token' => 'required',
            'password' => 'required|min:8',
            'uuid' => 'required',
        ]);

        $contact = Contact::findUuid($validated['uuid']);

        $status = Password::reset([
            'email' => $contact?->email,
            'password' => $validated['password'],
            'token' => $validated['token'],
        ], function ($user, $password) {
                $user->forceFill([
                    'password' => \Illuminate\Support\Facades\Hash::make($password)
                ])->setRememberToken(\Illuminate\Support\Str::random(60));

                $user->save();
        });

        if($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')
            ->with('status', 'Password successfully reset. Please Log in here with the new password.');
        }
        return redirect()->route('password.request')->withErrors(['token' => 'The token has expired, please request a new one here.']);

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
