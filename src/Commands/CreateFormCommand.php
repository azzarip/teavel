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
        $classPath = app_path('Teavel/Goals/Forms');

        $parts = explode('\\', $this->argument('name'));
        $formName = array_pop($parts);

        if ($parts) {
            $classPath = $classPath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts);
            $namespace = '\\' . implode('\\', $parts);
        } else {
            $namespace = null;
        }

        if (! File::exists($classPath)) {
            File::makeDirectory($classPath, 0755, true);
        }

        $classFile = $classPath . DIRECTORY_SEPARATOR . $formName . '.php';
        if (File::exists($classFile)) {
            $this->error('Form Class already exists');

            return 1;
        }

        File::copy(__DIR__ . '/../../stubs/Form.php.stub', $classFile);

        $fileContent = File::get($classFile);
        $fileContent = str_replace('{FORM_NAME}', $formName, $fileContent);
        $fileContent = str_replace('{NAMESPACE}', $namespace, $fileContent);
        File::put($classFile, $fileContent);

        $this->info('Form created successfully.');

        return 0;
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'How should the Form Goal be called?',
        ];
    }
}
