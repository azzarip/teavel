<?php

namespace Azzarip\Teavel\Mail\Mailables;

use Azzarip\Teavel\Mail\MailableTemplate;

class PasswordRegisterMail extends MailableTemplate
{
    protected $filename = 'password-reset-register';

    protected function loadData()
    {
        $this->data['url'] = route('register');
    }
}
