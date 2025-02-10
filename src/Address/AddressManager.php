<?php

namespace Azzarip\Teavel\Address;

use Azzarip\Teavel\Models\Address;
use Livewire\Attributes\Locked;
use Livewire\Component;

class AddressManager extends Component
{
    public $shippingAddress;

    public $billingAddress;

    public $addresses;

    public $count;

    #[Locked]
    public ?string $backUrl;

    public function __construct(?string $backUrl = null)
    {
        $this->backUrl = $backUrl;
    }

    public function render()
    {
        $this->loadAddresses();

        return view('teavel::address.manager');
    }

    public function selectAddress($id, $type)
    {
        $contact = auth()->user();
        $contact->update([
            $type . '_id' => $id,
        ]);
        $this->{$type . 'Address'} = $contact->{$type . 'Address'};
    }

    public function delete($id)
    {
        Address::find($id)->remove();
        $this->loadAddresses();
        auth()->user()->refresh();
    }

    protected function loadAddresses()
    {
        $contact = auth()->user();
        $this->shippingAddress = $contact->shippingAddress;
        $this->billingAddress = $contact->billingAddress;

        $this->addresses = $contact->addresses->pluck('two_lines', 'id')->reverse();

        $this->count = count($this->addresses);
    }
}
