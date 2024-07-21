<?php

namespace Azzarip\Teavel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateFormCommand extends Command
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

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $directory .= '/Goals';

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $directory .= '/Forms';

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $name = $this->argument('name');
        $cName = str_replace(' ', '', ucwords(str_replace('_', ' ', str_replace('-', ' ', $name))));

        $stubPath = __DIR__ . '/../../stubs/Form.php.stub';
        File::copy($stubPath, $directory . '/' . $cName . '.php');

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
