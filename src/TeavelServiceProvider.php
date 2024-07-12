<?php

namespace Azzarip\Teavel;

use Azzarip\Teavel\Commands;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Spatie\LaravelPackageTools\Package;
use Azzarip\Teavel\Filament\Panels\TeavelPanelProvider;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;


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
                    ->endWith(fn () => Artisan::call('teavel:contact-model'))
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
    }

    protected function getAssetPackageName(): ?string
    {
        return 'azzarip/teavel';
    }

    protected function getCommands(): array
    {
        return [
            Commands\ContactModelCommand::class,
        ];
    }

    protected function getMigrations(): array
    {
        return [
            'create_contacts_table',
            'create_addresses_table',
            'create_tags_table',
        ];
    }
}
