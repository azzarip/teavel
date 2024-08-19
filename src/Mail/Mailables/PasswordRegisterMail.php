<?php

namespace Azzarip\Teavel\Mail\Mailables;

use Azzarip\Teavel\Mail\TeavelMailable;

class PasswordRegisterMail extends TeavelMailable
{
    protected $filename = 'password-reset-register';

    public function __construct() {
        $this->data['url'] = route('register');
    }

}
