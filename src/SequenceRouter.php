<?php

namespace Azzarip\Teavel;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Exceptions\TeavelException;
use Azzarip\Teavel\Exceptions\BadMethodCallException;

class SequenceRouter
{
    public static function start(Sequence $sequence, Contact $contact)
    {
        $Name = ns_case($sequence->name);
        $className = 'App\\Teavel\\Sequences\\' . $Name;

        if (! class_exists($className)) {
            throw new TeavelException("Sequence $Name class not found!");
        }

        try {
            $className::start($contact);
        } catch (\BadMethodCallException $e) {
            throw new BadMethodCallException("Sequence $Name does not have a start method!");
        }
    }
}
