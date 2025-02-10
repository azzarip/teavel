<?php

namespace Azzarip\Teavel\Mail\Mailables;

use Azzarip\Teavel\Mail\MailableTemplate;

class PasswordResetMail extends MailableTemplate
{
    protected $filename = 'password-reset';

    public function token(string $token)
    {
        $url = route('password.reset', [
            'token' => $token,
            'uuid' => $this->contact->uuid,
        ]);

        $this->data['url'] = $url;

        return $this;
    }
}
