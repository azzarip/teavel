<?php

namespace Azzarip\Teavel\Listeners;

use Azzarip\Teavel\Events\FormSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferPurchasedAchieved implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(FormSubmitted $event): void
    {
        $automation = $event->form->name;
        $goal = new $automation($event->contact);
        $goal->activate();
    }
}
