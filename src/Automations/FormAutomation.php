<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;

class FormAutomation
{
    public function __construct(public Contact $contact)
    {}

    protected array $start = [];

    protected array $stop = [];

    public static function activate(Contact $contact) {
        $goal = new self($contact);
        $goal->stopAutomations();
        $goal->startAutomations();
    }

    public function stopAutomations()
    {
        foreach($this->stop as $automation) {
            (new $automation($this->contact))->stopSequence();
        }
    }

    public function startAutomations()
    {
        foreach($this->start as $automation) {
            (new $automation($this->contact))->startSequence();
        }
    }
}
