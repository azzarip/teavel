<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;

class FormAutomation extends GoalAutomation {


    public static function dispatchAfterResponse(Contact $contact): void 
    {
        \Azzarip\Teavel\Jobs\CompleteForm::dispatchAfterResponse($contact, self::class);
    }
}
