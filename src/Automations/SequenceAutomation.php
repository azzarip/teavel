<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;

class SequenceAutomation
{
   public function __construct(public Sequence $sequence, public Contact $contact) {}
}
