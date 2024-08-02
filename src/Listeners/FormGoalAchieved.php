<?php

namespace Azzarip\Teavel\Listeners;

use Azzarip\Teavel\Events\FormSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;

class FormGoalAchieved implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(FormSubmitted $event): void
    {
        $automation = $event->form->getAutomation();
        $goal = new $automation($event->contact);
        $goal->activate();
    }
}
