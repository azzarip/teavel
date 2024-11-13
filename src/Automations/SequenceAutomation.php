<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;
use App\Models\User;
class SequenceAutomation
{
    protected User $owner;
    public function __construct(public Contact $contact, protected ?int $sequenceId = null)
    {
        $this->owner = User::first();
    }

    public static function stopSequence(Contact $contact)
    {
        Sequence::name(get_called_class())->stop($contact);
    }
    public static function startSequence(Contact $contact)
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
}
