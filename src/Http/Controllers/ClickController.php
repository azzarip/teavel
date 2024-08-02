<?php

namespace Azzarip\Teavel\Http\Controllers;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Email;

class ClickController
{
    public function __invoke($emailUuid, $contactUuid, int $num)
    {
        $email = Email::findUuid($emailUuid);

        if (empty($email)) {
            return abort(404);
        }

        $links = $email->getLinks();
        if (! array_key_exists($num, $links)) {
            return abort(404);
        }
        $link = $links[$num];
        $contact = Contact::findUuid($contactUuid);

        if ($contact) {
            $pivot = $email->contacts()->wherePivot('contact_id', $contact->id)->first()->pivot;
            $pivot->click();
        }

        return redirect($link, 301);
    }
}
