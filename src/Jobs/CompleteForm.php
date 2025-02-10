<?php

namespace Azzarip\Teavel\Jobs;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompleteForm implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Contact $contact, protected string $form)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->contact->completeForm($this->form);

    }
}
