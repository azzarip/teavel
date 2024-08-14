<?php

namespace Azzarip\Teavel\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;

class CreateEmailCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'make:teavel-mail {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Teavel Email Content and Goal';

    public function handle()
    {
        $classPath = app_path('Teavel/Emails');
        $contentPath = base_path('content/emails');

        $parts = explode('\\', $this->argument('name'));
        $emailName = array_pop($parts);

        if($parts) {
            $classPath = $classPath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts);
            $namespace = '\\' . implode('\\', $parts);
            $contentPath = $contentPath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts);
        } else {
            $namespace = null;
        }

        $this->createDirectory($classPath);
        $this->createDirectory($contentPath);

        $classFile = $classPath . DIRECTORY_SEPARATOR . $emailName . '.php';
        if (File::exists($classFile)) {
            $this->error('Email Class already exists');
            return 1;
        }

        $contentFile = $contentPath . DIRECTORY_SEPARATOR . $emailName . '.md';
        if (File::exists($contentFile)) {
            $this->error('Email content already exists.');
            return 1;
        }

        File::copy(__DIR__ . '/../../stubs/Email.php.stub', $classFile);
        File::copy(__DIR__ . '/../../stubs/email.md.stub', $contentFile);

        $fileContent = File::get($classFile);
        $fileContent = str_replace('{EMAIL_NAME}', $emailName, $fileContent);
        $fileContent = str_replace('{NAMESPACE}', $namespace, $fileContent);
        File::put($classFile, $fileContent);

        $this->info('Email created successfully.');

        return 0;
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'How should the Email be called?',
        ];
    }

    protected function createDirectory($string)
    {
        if (! File::exists($string)) {
            File::makeDirectory($string, 0755, true);
        }
    }
}
