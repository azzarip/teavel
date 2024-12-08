<?php

namespace Azzarip\Teavel\Events;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Offer;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferPurchased
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Offer $offer,
        public Contact $contact
    ) {}
}
