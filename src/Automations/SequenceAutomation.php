<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;

class SequenceAutomation
{
    public function __construct(public Contact $contact, protected ?int $sequenceId = null)
    {
    }

    public static function stopSequence(Contact $contact)
    {
        Sequence::name(self::class)->stop($contact);
    }
    public static function startSequence(Contact $contact)
    {
        Sequence::name(self::class)->start($contact);
    }

    protected function tag($tag)
    {
        $this->contact->tag($tag);
    }

    protected function detag($tag)
    {
        $this->contact->detag($tag);
    }

    protected function sendEmail($email)
    {
        $this->contact->sendEmail($email, $this->sequenceId);
    }
}
