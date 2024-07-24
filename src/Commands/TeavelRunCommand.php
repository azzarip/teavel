<?php

namespace Azzarip\Teavel\Commands;

use Azzarip\Teavel\Automations\SequenceHandler;
use Azzarip\Teavel\Models\ContactSequence;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TeavelRunCommand extends Command
{
    protected $signature = 'teavel:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the Teavel automations';

    public function handle()
    {
        $steps = ContactSequence::getReadySteps();

        ContactSequence::ready()->update(['execute_at' => null]);

        foreach ($steps as $step) {
            $this->executeStep($step);
        }

        return 1;
    }

    protected function executeStep(ContactSequence $step)
    {
        try {
            SequenceHandler::handle($step);
        } catch (\Exception $e) {
            Log::error('TEAVEL: ' . $e->getMessage());
        }
    }
}
