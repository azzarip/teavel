<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;

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
            $this->stopSequence($sequence);
        }
    }

    public function startSequences()
    {
        foreach ($this->start as $sequence) {
            $this->startSequence($sequence);
        }
    }

    public function stopSequence($sequence)
    {
        $sequence::stopSequence($this->contact);
    }

    public function startSequence($sequence)
    {
        $sequence::startSequence($this->contact);
    }

}
