<?php

namespace Azzarip\Teavel\Filament\Panels;

use Filament\Pages\Dashboard;
use Azzarip\Utilities\Http\Middleware\English;
use Azzarip\Utilities\Filament\Items\BackMain;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TeavelPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('teavel')
            ->path('teavel')
            ->login()
            ->authGuard(config('teavel.panel.auth', 'admin'))
            ->domain(config('teavel.panel.domain'))
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: base_path('/vendor/azzarip/teavel/src/Filament/Resources'), for: 'Azzarip\\Teavel\\Filament\\Resources')
            ->discoverPages(in: base_path('/vendor/azzarip/teavel/src/Filament/Pages'), for: 'Azzarip\\Teavel\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->navigationItems([
                BackMain::make(),
            ])
            ->discoverWidgets(in: base_path('/vendor/azzarip/teavel/src/Filament/Widgets'), for: 'Azzarip\\Teavel\\Filament\\Widgets')
            ->widgets([])
            ->middleware([
                English::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                Azzarip\Utilities\Http\Middleware\AdminConfig::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
