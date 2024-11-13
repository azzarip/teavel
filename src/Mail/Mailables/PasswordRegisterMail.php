<?php

namespace Azzarip\Teavel\Mail\Mailables;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Mail\TeavelMailable;

class PasswordRegisterMail extends TeavelMailable
{
    protected $filename = 'password-reset-register';

    protected array $data = [
        'url' => route('register'),
    ];

}
