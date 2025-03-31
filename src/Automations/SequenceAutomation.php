<?php

namespace Azzarip\Teavel\Automations;

use App\Models\User;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;

class SequenceAutomation
{
    protected User $owner;

    public function __construct(public Contact $contact, protected ?int $sequenceId = null)
    {
        $this->owner = User::first();
    }

    public static function stopThisSequence(Contact $contact)
    {
        Sequence::name(get_called_class())->stop($contact);
    }

    public static function startThisSequence(Contact $contact)
    {
        Sequence::name(get_called_class())->start($contact);
    }

    protected function tag($tag)
    {
        $this->contact->tag($tag);
    }

    protected function detag($tag)
    {
        $this->contact->detag($tag);
    }

    protected function email($email)
    {
        $this->contact->email($email, $this->sequenceId);
    }

    protected function owner()
    {
        return $this->owner;
    }

    protected function startSequence(string $sequence)
    {
        Sequence::name( $sequence)->start($this->contact);
    }
}
