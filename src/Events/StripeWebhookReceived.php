<?php

namespace Azzarip\Teavel\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StripeWebhookReceived
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public $stripeEvent)
    {
        //
    }
}
