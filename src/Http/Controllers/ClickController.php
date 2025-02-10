<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Email;
use Illuminate\Support\Facades\Log;

class ClickController
{
    public function __invoke($contactUuid, $emailUuid, $action)
    {
        $email = Email::findUuid($emailUuid);
        if (empty($email)) {
            abort(404);
        }

        $contact = Contact::findUuid($contactUuid);
        if (empty($contact)) {
            abort(404);
        }

        $email->contacts()->wherePivot('contact_id', $contact->id)->first()?->pivot->click();

        $automation = new ($email->getAutomation())($contact);

        if (! method_exists($automation, $action)) {
            Log::error("Email {$email->uui} has missing {$action}");
            abort(404);
        }

        $redirect = $automation->$action();

        return redirect($redirect, 301);
    }
}
