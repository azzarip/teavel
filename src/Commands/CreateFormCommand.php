<?php

namespace Azzarip\Teavel\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;

class CreateFormCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'make:teavel-form {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Teavel Form Goal';

    public function handle()
    {
        $directory = app_path('Teavel');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $directory .= '/Goals';

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $directory .= '/Forms';

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $name = $this->argument('name');
        $cName = ns_case($name);
        $filepath = $directory . '/' . $cName . '.php';
        if (File::exists($filepath)) {
            return 1;
        }

        $stubPath = __DIR__ . '/../../stubs/Form.php.stub';
        File::copy($stubPath, $filepath);

        $fileContent = File::get($filepath);
        $modifiedContent = str_replace('cNAMEc', $cName, $fileContent);
        $modifiedContent = str_replace('xNAMEx', $name, $modifiedContent);
        File::put($filepath, $modifiedContent);

        $this->info('Form Goal created successfully.');

        return 0;
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'How should the Form Goal be called?',
        ];
    }
}
