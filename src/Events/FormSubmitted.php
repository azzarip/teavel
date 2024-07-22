<?php

namespace Azzarip\Teavel\Events;


use Azzarip\Teavel\Models\Form;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class FormSubmitted
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Form $form,
        public Contact $contact
        )
    {}
}
