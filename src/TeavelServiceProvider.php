<?php

namespace Azzarip\Teavel;

use Azzarip\Teavel\Address\AddressManager;
use Azzarip\Teavel\Address\AddressRouter;
use Azzarip\Teavel\Filament\Panels\TeavelPanelProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;
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
            ->hasViews()
            ->hasRoutes('routes')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->endWith(function () {
                        $this->publishContactModel();
                        $this->publishEmailCss();
                    })
                    ->askToStarRepoOnGitHub('azzarip/teavel');
            });

    }

    public function bootingPackage()
    {
        Blade::anonymousComponentPath(
            $this->getPath() . '/views/forms',
            'forms'
        );
        Blade::anonymousComponentPath(
            $this->getPath() . '/views/modals',
            'modals'
        );
        Livewire::component('address-manager', AddressManager::class);
        Blade::component('address-router', AddressRouter::class);
        app('router')->aliasMiddleware('locale', \Azzarip\Teavel\Http\Middleware\Locale::class);
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
            Commands\CreateFormCommand::class,
            Commands\CreateEmailCommand::class,
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
            'create_offers_table',
        ];
    }

    protected function registerEvents()
    {
        Event::listen(
            Events\FormSubmitted::class,
            Listeners\FormGoalAchieved::class,
        );
        Event::listen(
            Events\OfferPurchased::class,
            Listeners\OfferGoalAchieved::class,
        );
    }

    protected function publishContactModel()
    {
        $modelPath = app_path('Models/Contact.php');

        if (File::exists($modelPath)) {
            return;
        }

        $stubPath = __DIR__ . '/../stubs/Contact.php.stub';
        File::copy($stubPath, $modelPath);
    }

    protected function publishEmailCss()
    {
        $filePath = resource_path('css/email.css');

        if (File::exists($filePath)) {
            return;
        }

        $stubPath = __DIR__ . '/../stubs/email.css.stub';
        File::copy($stubPath, $filePath);
    }

    protected function getPath()
    {
        return base_path() . '/vendor/azzarip/teavel/resources';
    }
}
