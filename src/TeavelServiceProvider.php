<?php

namespace Azzarip\Teavel;

use Azzarip\Teavel\Filament\Panels\TeavelPanelProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TeavelServiceProvider extends PackageServiceProvider
{
    public static string $name = 'teavel';

    public static string $viewNamespace = 'teavel';

    public function configurePackage(Package $package): void
    {

        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasMigrations($this->getMigrations())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    //->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->endWith(function () {
                        Artisan::call('teavel:contact-model');

                    })
                    ->askToStarRepoOnGitHub('azzarip/teavel');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        $this->app->register(TeavelPanelProvider::class);
    }

    public function packageBooted(): void
    {
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/teavel/{$file->getFilename()}"),
                ], 'teavel-stubs');
            }
        }

        $this->registerEvents();
    }

    protected function getAssetPackageName(): ?string
    {
        return 'azzarip/teavel';
    }

    protected function getCommands(): array
    {
        return [
            Commands\ContactModelCommand::class,
            Commands\CreateFormCommand::class,
            Commands\CreateSequenceCommand::class,
            Commands\TeavelRunCommand::class,
        ];
    }

    protected function getMigrations(): array
    {
        return [
            'create_contacts_table',
            'create_addresses_table',
            'create_tags_table',
            'create_forms_table',
            'create_sequences_table',
            'create_emails_table',
        ];
    }

    protected function registerEvents()
    {
        Event::listen(
            Events\FormSubmitted::class,
            Listeners\FormGoalAchieved::class,
        );
    }
}
