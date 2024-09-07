<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Models\Address;
use Illuminate\Support\Facades\Auth;
use Azzarip\Teavel\Http\Requests\SwissAddressRequest;

class AddressController
{
    public function store(SwissAddressRequest $request)
    {
        $validated = $request->validated();

        $options = array_keys($request->only('billing', 'shipping'));
        Auth::user()->createAddress($validated, $options);

        return redirect($request['redirect'] ?? route('address'));
    }

    public function update(SwissAddressRequest $request)
    {
        $id = $request->validate(['id' => 'required|int'])['id'];
        $address = Address::find($id);

        if(! $address) {
            abort(403);
        }
        if($address->contact_id != Auth::user()->id){
            abort(403);
        }

        $address->delete();

        $contact = Auth::user();
        $options = array_keys($request->only('billing', 'shipping'));

        if($contact->shipping_id == $id) {
            $options[] = 'shipping';
        }
        if($contact->billing_id == $id) {
            $options[] = 'billing';
        }

        $validated = $request->validated();
        $contact->createAddress($validated, $options);

        return redirect($request['redirect']?? route('address'));
    }
}
