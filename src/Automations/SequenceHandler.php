<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Exceptions\BadMethodCallException;
use Azzarip\Teavel\Exceptions\MissingClassException;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\ContactSequence;
use Azzarip\Teavel\Models\Sequence;

class SequenceHandler
{
    protected $step;

    public function __construct(
      public ContactSequence $pivot,
      public Contact $contact,
      protected SequenceAutomation $automation
   )
    {
      $this->step = $pivot->step ?? 'start';
    }

    public function handle()
    {
        try {
            $automation = (new ($this->automation)($this->contact));
            $next = $automation->{$this->step}();
            $this->nextStep($next);
        } catch (\BadMethodCallException $e) {
            throw new BadMethodCallException("Sequence ". get_class($this->automation). "does not have a $this->step method!");
        }
    }

    public static function process(ContactSequence $pivot)
    {
        $automation = Sequence::find($pivot->sequence_id)->getAutomation();
        $contact = Contact::find($pivot->contact_id);

        self::start($pivot, $contact, $automation);
    }

    public static function start(ContactSequence $pivot, Contact $contact, SequenceAutomation $automation)
    {
        $handler = new self($pivot, $contact, $automation);
        $handler->handle();
    }

    protected function nextStep($next)
    {
        if(is_null($next)) {
            return $this->pivot->stop();
        }

        $this->pivot->execute_at = $next->getAdjustedTimestamp();
        $this->pivot->step = $next->step;
        $this->pivot->save();
    }

}
