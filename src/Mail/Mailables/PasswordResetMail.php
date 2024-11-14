<?php

namespace Azzarip\Teavel\Mail\Mailables;

use Azzarip\Teavel\Mail\MailableTemplate;

class PasswordResetMail extends MailableTemplate
{
    protected $filename = 'password-reset';

    public function token(string $token) {
        $url = route('password.reset', [
            'token' => $token,
        ]);

        $this->data['url'] = $url;
    }
}
