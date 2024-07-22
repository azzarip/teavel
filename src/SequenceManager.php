<?php

namespace Azzarip\Teavel;

use Azzarip\Teavel\Exceptions\TeavelException;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;

class SequenceManager
{
    public static function start(Sequence $sequence, Contact $contact)
    {
        $className = 'App\\Teavel\\Sequences\\' . ns_case($sequence->name);

        if (! class_exists($className)) {
            throw new TeavelException("Sequence $sequence->name class not found!");
        }

        if (! method_exists($className, 'start')) {
            throw new TeavelException("Sequence $sequence->name does not have a start method!");
        }

        $className::start($contact);
    }
}
