<?php

namespace Azzarip\Teavel\Listeners;

use Azzarip\Teavel\Events\FormSubmitted;
use Azzarip\Teavel\Models\Form;
use Illuminate\Contracts\Queue\ShouldQueue;

class FormGoalAchieved implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(FormSubmitted $event): void
    {
        $automationGoal = $event->form->getAutomation();

        $automationGoal::activate($event->contact);
    }


}
