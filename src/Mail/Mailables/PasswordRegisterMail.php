<?php

namespace Azzarip\Teavel\Mail\Mailables;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Mail\TeavelMailable;

class PasswordRegisterMail extends TeavelMailable
{
    protected $filename = 'password-reset-register';

    public function __construct(protected Contact $contact) {
        $this->data['url'] = route('register');
    }

}
