<?php

namespace Azzarip\Teavel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateSequenceCommand extends Command
{
    protected $signature = 'make:teavel-sequence {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Teavel Sequence';

    public function handle()
    {
        $directory = app_path('Teavel');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $directory .= '/Sequences';

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $name = $this->argument('name');
        $cName = ns_case($name);
        $filepath = $directory . '/' . $cName . '.php';
        if (File::exists($filepath)) {
            return 1;
        }

        $stubPath = __DIR__ . '/../../stubs/Sequence.php.stub';
        File::copy($stubPath, $filepath);

        $fileContent = File::get($filepath);
        $modifiedContent = str_replace('cNAMEc', $cName, $fileContent);
        $modifiedContent = str_replace('xNAMEx', $name, $modifiedContent);
        File::put($filepath, $modifiedContent);

        $this->info('Sequence created successfully.');

        return 0;
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'How should the Sequence be called?',
        ];
    }
}
