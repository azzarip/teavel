<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Exceptions\BadMethodCallException;
use Azzarip\Teavel\Exceptions\MissingClassException;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\ContactSequence;
use Azzarip\Teavel\Models\Sequence;

class SequenceHandler
{
    protected $namespace;

    protected $step;

    public function __construct(public ContactSequence $pivot, public Contact $contact, public Sequence $sequence)
    {
        $this->namespace = $this->getNamespace();
        $this->step = $pivot->step ?? 'start';
    }

    public function run()
    {
        try {
            $automation = (new ($this->namespace)($this->sequence, $this->contact));
            $automation->{$this->step}();
        } catch (\BadMethodCallException $e) {
            throw new BadMethodCallException("Sequence {$this->sequence->name} does not have a $this->step method!");
        }
    }

    public static function handle(ContactSequence $pivot)
    {
        $sequence = Sequence::find($pivot->sequence_id);
        $contact = Contact::find($pivot->contact_id);

        $handler = new self($pivot, $contact, $sequence);
        $handler->run();
    }

    public static function start(ContactSequence $pivot, Contact $contact, Sequence $sequence)
    {
        $handler = new self($pivot, $contact, $sequence);
        $handler->run();
    }

    protected function getNamespace()
    {
        $Name = ns_case($this->sequence->name);
        $className = 'App\\Teavel\\Sequences\\' . $Name;

        if (! class_exists($className)) {
            throw new MissingClassException("Sequence $Name class not found!");
        }

        return $className;
    }
}
