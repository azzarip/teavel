<?php

namespace Azzarip\Teavel\Listeners;

use Azzarip\Teavel\Events\FormSubmitted;
use Azzarip\Teavel\Models\Form;
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
        $goalClass = $this->getNamespace($event->form);
        $goalClass::start();
    }

    protected function getNamespace(Form $form): string
    {
        return '\\App\\Teavel\\Goals\\Forms\\' . ns_case($form->name);
    }
}
