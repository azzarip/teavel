<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Exceptions\BadMethodCallException;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\ContactSequence;
use Azzarip\Teavel\Models\Sequence;

class SequenceHandler
{
    protected $step;

    protected int $sequenceId;

    public function __construct(
        public ContactSequence $pivot,
        public Contact $contact,
        protected $automation
    ) {
        $this->step = $pivot->step ?? 'start';
    }

    public function handle()
    {
        try {
            $automation = new ($this->automation)($this->contact, $this->pivot->sequence_id);
            $next = $automation->{$this->step}();

            $this->nextStep($next);
        } catch (\BadMethodCallException $e) {
            throw new BadMethodCallException('Sequence ' . $this->automation . " does not have a $this->step method!");
        }
    }

    public static function process(ContactSequence $pivot)
    {
        $automation = Sequence::find($pivot->sequence_id);
        $contact = Contact::find($pivot->contact_id);

        self::start($pivot, $contact, $automation->name);
    }

    public static function start(ContactSequence $pivot, Contact $contact, $automation)
    {
        $handler = new self($pivot, $contact, $automation);
        $handler->handle();
    }

    protected function nextStep($next)
    {
        if ($next === null) {
            return $this->pivot->stop();
        }
        
        $this->pivot->updateValues([
            'execute_at' => $next->getRandomizedTimestamp(),
            'step' => $next->step,
        ]);
    }
}
