<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;

class SequenceAutomation
{
    public readonly $key;

    public function __construct(public Contact $contact)
    {
    }

    public static function stop(Contact $contact) {
        Sequence::name($this->key)->stop($contact);
    }

    public static function startHandler(Contact $contact){
        Sequence::name($this->key)->start($contact);
    }

    
}
