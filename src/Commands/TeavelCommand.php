<?php

namespace Azzarip\Teavel\Commands;

use Illuminate\Console\Command;

class TeavelCommand extends Command
{
    public $signature = 'teavel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
