<?php

namespace Azzarip\Teavel\Tests;

use Azzarip\Teavel\TeavelServiceProvider;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Azzarip\\Teavel\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            // ActionsServiceProvider::class,
            // BladeCaptureDirectiveServiceProvider::class,
            // BladeHeroiconsServiceProvider::class,
            // BladeIconsServiceProvider::class,
            // FilamentServiceProvider::class,
            // FormsServiceProvider::class,
            // InfolistsServiceProvider::class,
            // LivewireServiceProvider::class,
            // NotificationsServiceProvider::class,
            // SupportServiceProvider::class,
            // TablesServiceProvider::class,
            // WidgetsServiceProvider::class,
            TeavelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $files = File::glob(__DIR__ . '/../database/migrations/*.php.stub');
        foreach ($files as $file) {
            (include $file)->up();
        }
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
