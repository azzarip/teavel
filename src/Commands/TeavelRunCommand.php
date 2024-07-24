<?php

namespace Azzarip\Teavel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateFormCommand extends Command
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

}
