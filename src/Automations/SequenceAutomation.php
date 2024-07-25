<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;

class SequenceAutomation
{
    public string $name;

    public function __construct(public Contact $contact)
    {
    }

    public function stopSequence() {
        Sequence::name($this->name)->stop($this->contact);
    }

    public function startSequence(){
        Sequence::name($this->name)->start($this->contact);
    }

    protected function tag($tag){
        $this->contact->tag($tag);
    }

    protected function detag($tag){
        $this->contact->detag($tag);
    }

}
