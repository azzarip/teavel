<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;

abstract class FormAutomation extends GoalAutomation {


    public static function complete(Contact $contact): void 
    {
        \Azzarip\Teavel\Jobs\CompleteForm::dispatch($contact, static::class);
    }
}
