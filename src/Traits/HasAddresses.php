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
}
