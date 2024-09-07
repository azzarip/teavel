<?php

namespace Azzarip\Teavel\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Azzarip\Teavel\Http\Requests\SwissAddressRequest;

class AddressController
{
    public function store(SwissAddressRequest $request)
    {
        $validated = $request->validated();

        $options = array_keys($request->only('billing', 'shipping'));
        Auth::user()->createAddress($validated, $options);

        return back();
    }
}
