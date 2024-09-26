<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Models\Address;

trait HasAddresses
{
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getHasAddressAttribute(): bool
    {
        if (empty($this->shipping_id) && empty($this->billing_id)) {
            return false;
        }

        return true;
    }

    public function createAddress(array $address, array $options = [])
    {
        $address = Address::mutateAndCreate($address + [
            'contact_id' => $this->id,
        ]);

        $updates = [];

        if (in_array('shipping', $options)) {
            $updates['shipping_id'] = $address->id;
        }

        if (in_array('billing', $options)) {
            $updates['billing_id'] = $address->id;
        }

        if (!empty($updates)) {
            $this->update($updates);
        }

        return $address;

    }

    public function getRecipientAttribute() {
        if($this->billing_id) {
            return $this->billingAddress->toArray();
        } else {
            return [$this->full_name];
        }
    }

    public function updateAddress(int $id, array $data, array $options = [])
    {
        $address = Address::find($id);

        if(empty($address)) {
            return abort(404);
        }

        if($address->contact_id != $this->id){
            return abort(403);
        }

        $address->update($data);

        $updates = [];

        if (in_array('shipping', $options)) {
            $updates['shipping_id'] = $address->id;
        }

        if (in_array('billing', $options)) {
            $updates['billing_id'] = $address->id;
        }

        if (!empty($updates)) {
            $this->update($updates);
        }

        return $address;

    }
}
