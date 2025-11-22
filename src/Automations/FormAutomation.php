<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Jobs\CompleteForm;
use Azzarip\Teavel\Models\Contact;

abstract class FormAutomation extends GoalAutomation {


    public static function complete(Contact $contact): void 
    {
        CompleteForm::dispatch($contact, static::class);
    }
}
