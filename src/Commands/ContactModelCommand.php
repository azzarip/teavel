<?php

namespace Azzarip\Teavel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ContactModelCommand extends Command
{
    protected $signature = 'teavel:contact-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the Contact Model';

    public function handle()
    {
        $modelPath = app_path('Models/Contact.php');

        if (File::exists($modelPath)) {
            $this->error('Error: Contact model already exists.');

            return 1;
        }

        $stubPath = __DIR__ . '/../../stubs/Contact.php.stub';
        File::copy($stubPath, $modelPath);
        $this->info('Contact model created successfully.');

        return 0; // Success code
    }
}
