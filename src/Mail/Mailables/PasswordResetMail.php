<?php

namespace Azzarip\Teavel\Mail\Mailables;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Mail\TeavelMailable;

class PasswordResetMail extends TeavelMailable
{
    protected $filename = 'password-reset';

    public function __construct(protected Contact $contact, string $token) {
        $this->setUrl($token);
    }

    protected function setUrl($token)
    {
        $url = route('password.reset', [
            'token' => $token,
        ]);

        $this->data['url'] = $url;
    }

}
