<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Email;

class ClickController
{
    public function __invoke($contactUuid, $emailUuid, $action)
    {
        $email = Email::findUuid($emailUuid);
        if (empty($email)) abort(404);

        $contact = Contact::findUuid($contactUuid);
        if (empty($contact)) abort(404);

        $pivot = $email->contacts()->wherePivot('contact_id', $contact->id)->first()?->pivot;
        if(!$pivot) abort(404);
        $pivot->click();

        $automation = new ($email->getAutomation())();
        $redirect = $automation->$action();
        return redirect($redirect, 301);
    }
}
