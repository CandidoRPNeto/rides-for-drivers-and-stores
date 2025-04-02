<?php

namespace App\Providers\Filament;

use App\Filament\Stores\Auth\LoginStoreForm;
use App\Filament\Stores\Auth\RegisterStoreForm;
use App\Http\Middleware\VerifyCsrfTokenMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class StorePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->registration(RegisterStoreForm::class)
            ->login(LoginStoreForm::class)
            ->colors([
                'primary' => Color::hex('#26D07C'),
            ])
            ->font('Poppins')
            ->discoverResources(in: app_path('Filament/Stores/Resources'), for: 'App\\Filament\\Stores\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Stores\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Stores\\Widgets')
            ->pages([
                \App\Filament\Stores\Pages\StoreSettings::class,
                \App\Filament\Stores\Pages\PurchasePage::class,
            ])
            ->brandName('Janus')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                VerifyCsrfTokenMiddleware::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
