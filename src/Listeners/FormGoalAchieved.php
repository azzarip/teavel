<?php

namespace Azzarip\Teavel\Listeners;

use Azzarip\Teavel\Events\FormSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;

class FormGoalAchieved implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FormSubmitted $event): void
    {
        //
    }
}
