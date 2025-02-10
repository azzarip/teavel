<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Exceptions\TeavelException;
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
            if ($sequence instanceof Azzarip\Teavel\Automations\SequenceAutomation) {
                $sequence::stopSequence($this->contact);
            } else {
                throw new TeavelException('Class ' . get_class($sequence) . " is not an instance of Azzarip\Teavel\Automations\SequenceAutomation");
            }

        }
    }

    public function startSequences()
    {
        foreach ($this->start as $sequence) {
            if ($sequence instanceof Azzarip\Teavel\Automations\SequenceAutomation) {
                $sequence::startSequence($this->contact);
            } else {
                throw new TeavelException('Class ' . get_class($sequence) . " is not an instance of Azzarip\Teavel\Automations\SequenceAutomation");
            }
        }
    }
}
