<?php

namespace Azzarip\Teavel\Events;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Form;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormSubmitted
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Form $form,
        public Contact $contact
    ) {
    }
}
