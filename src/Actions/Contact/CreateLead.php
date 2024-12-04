<?php

namespace Azzarip\Teavel\Actions\Contact;

use Azzarip\Teavel\Models\Contact;

class CreateLead {

    public static function create(string $email)
    {
        return Contact::createOrFirst([
            'email' => $email,
        ], [
            'privacy_at' => now(),
            'opt_in' => true
        ]);
    }
}