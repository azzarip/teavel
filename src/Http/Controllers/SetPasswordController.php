<?php

namespace Azzarip\Teavel\Http\Controllers;

use Illuminate\Support\Str;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Azzarip\Teavel\Http\Requests\LoginRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SetPasswordController extends Controller
{
    use ValidatesRequests;

    public function __invoke(LoginRequest $request)
    {
        $validated = $request->validated();

        $contact = Contact::findEmail($validated['email']);

        if( ! $contact) {
            abort(403);
        }

        if($contact->isRegistered) {
            abort(403);
        }

        $contact->forceFill([
            'password' => Hash::make($validated['password'])
        ])->setRememberToken(Str::random(60));
        $contact->save();

        return redirect()->route('my');
    }
}
