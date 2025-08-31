<?php

namespace App\Providers\Filament;

use App\Filament\User\Pages\Auth\Login;
use Exception;
use Filament\Http\Middleware\{AuthenticateSession, DisableBladeIconComponents, DispatchServingFilamentEvent};
use Filament\{Panel, PanelProvider, Support\Enums\Width};
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\{AddQueuedCookiesToResponse, EncryptCookies};
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('user')
            ->path('/')
            ->navigation(false)
            ->maxContentWidth(Width::FourExtraLarge)
            ->globalSearch(false)
            ->login(Login::class)
            ->registration()
            ->profile()
            ->passwordReset()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\Filament\User\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\Filament\User\Pages')
            ->pages([
                //
            ])
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\Filament\User\Widgets')
            ->widgets([

            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                //
            ])
            ->viteTheme('resources/css/filament/user/theme.css');
    }
}
