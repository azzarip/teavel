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
            (new $sequence($this->contact))->stopSequence();
        }
    }

    public function startSequences()
    {
        foreach ($this->start as $automation) {
            (new $automation($this->contact))->startSequence();
        }
    }
}
