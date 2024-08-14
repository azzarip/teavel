<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\EmailUnsubscribe;

class UnsubscribeController
{
    public function __invoke($contactUuid, $emailUuid)
    {
        $contact = Contact::findUuid($contactUuid);
        if (empty($contact)) {
            return redirect('/emails/unsubscribe/success');
        }

        $contact->optOut();

        $email = Email::findUuid($emailUuid);
        EmailUnsubscribe::create([
            'contact_id' => $contact->id,
            'email_id' => $email ? $email->id : null,
        ]);

        return redirect('/emails/unsubscribe/success');
    }
}
