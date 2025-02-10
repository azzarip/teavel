<?php

namespace Azzarip\Teavel\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;

class CreateSequenceCommand extends Command implements PromptsForMissingInput
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
        $classPath = app_path('Teavel/Sequences');

        $parts = explode('\\', $this->argument('name'));
        $sequenceName = array_pop($parts);

        if ($parts) {
            $classPath = $classPath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts);
            $namespace = '\\' . implode('\\', $parts);
        } else {
            $namespace = null;
        }

        if (! File::exists($classPath)) {
            File::makeDirectory($classPath, 0755, true);
        }

        $classFile = $classPath . DIRECTORY_SEPARATOR . $sequenceName . '.php';
        if (File::exists($classFile)) {
            $this->error('Sequence Class already exists');

            return 1;
        }

        File::copy(__DIR__ . '/../../stubs/Sequence.php.stub', $classFile);

        $fileContent = File::get($classFile);
        $fileContent = str_replace('{SEQUENCE_NAME}', $sequenceName, $fileContent);
        $fileContent = str_replace('{NAMESPACE}', $namespace, $fileContent);
        File::put($classFile, $fileContent);

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
