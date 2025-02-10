<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Exceptions\TeavelException;
use Azzarip\Teavel\Automations\SequenceAutomation;

class GoalAutomation
{
    public function __construct(public Contact $contact) {}

    protected array $start = [];

    protected array $stop = [];

    public function activate()
    {
        $this->stopSequences();
        $this->startSequences();
    }

    public function stopSequences()
    {
        foreach ($this->stop as $sequence) {
            if (is_subclass_of($sequence, SequenceAutomation::class)) {
                $sequence::stopSequence($this->contact);
            } else {
                throw new TeavelException("Class $sequence is not an instance of Azzarip\Teavel\Automations\SequenceAutomation");
            }
                       
        }
    }

    public function startSequences()
    {
        foreach ($this->start as $sequence) {
            if (is_subclass_of($sequence, SequenceAutomation::class)) {
                $sequence::startSequence($this->contact);
            } else {
                throw new TeavelException("Class $sequence is not an instance of Azzarip\Teavel\Automations\SequenceAutomation");
            }
        }
    }
}