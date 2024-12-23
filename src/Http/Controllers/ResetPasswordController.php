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

class ResetPasswordController extends Controller
{
    use ValidatesRequests;

    public function reset(Request $request){
        $validated = $request->validate([
            'token' => 'required',
            'password' => 'required|min:8',
            'uuid' => 'required',
        ]);

        $contact = Contact::findUuid($validated['uuid']);

        if( ! Password::tokenExists($contact, $validated['token'])) {
            return redirect()->route('password.request')->withErrors(['token' => trans('teavel::auth.error.token')]);
        }

        $contact->forceFill([
            'password' => Hash::make($validated['password'])
        ])->setRememberToken(Str::random(60));
        $contact->save();

        Password::deleteToken($contact);

        return redirect()->route('login')
            ->with('info', trans('teavel::auth.info.reset'));
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
            PasswordRegisterMail::to($contact)->send();

            return;
        }

        $token = Password::getRepository()->create($contact);

        PasswordResetMail::to($contact)
            ->token($token)
            ->send();
    }

    public function change(Request $request)
    {
        $validated = $request->validate([
            'new_password' => 'required|min:8',
            'password' => 'required|min:8',
        ]);
        
        $contact = auth()->user();

        if ( ! Hash::check($validated['password'], $contact->password)) {
            return redirect()->back()->withErrors(['password' => trans('teavel::auth.password')]);
        } 

        $contact->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->back()->with(['info' => trans('teavel::auth.info.reset')]);

    }
}
