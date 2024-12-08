<?php

namespace Azzarip\Teavel\Listeners;

use Azzarip\Teavel\Events\OfferPurchased;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferGoalAchieved implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(OfferPurchased $event): void
    {
        $automation = $event->offer->getPurchasedGoal();
        $goal = new $automation($event->contact);
        $goal->activate();
    }
}
