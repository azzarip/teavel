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
        $goal = new self::($contact);
        $goal->stopAutomations();
        $goal->startAutomations();
    }

    public function stopAutomations() 
    {
        foreach($this->stop as $automation) {
            $automation::stop($this->contact);
        }
    }

    public function startAutomations() 
    {
        foreach($this->start as $automation) {
            $automation::startHandler($this->contact);
        }
    }
}
