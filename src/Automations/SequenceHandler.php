<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\ContactSequence;

class SequenceHandler
{
   public function __construct(public ContactSequence $pivot, public Contact $contact, public Form $fom) {}

   public function handle() {}

   public static function start(ContactSequence $pivot, Contact $contact)
   {
      dd($pivot);
      new self($pivot, $contact, $pivot->parent);
   }
}