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
        $address = Address::create($address + [
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
}
