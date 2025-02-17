<?php

namespace App\Providers\Filament;

use App\Filament\Resources\CuponResource;
use App\Filament\Resources\BosemResource;
use App\Filament\Resources\ElementosambResource;
use App\Filament\Resources\HerramientasambResource;
use App\Filament\Resources\AmbulanciaResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\ListaChequeoResource;
use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;
use Vormkracht10\TwoFactorAuth\TwoFactorAuthPlugin;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use Vormkracht10\TwoFactorAuth\Http\Livewire\Auth\Login;
use Rmsramos\Activitylog\ActivitylogPlugin;

class FlotaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('flota')
            ->darkMode(false)
            ->path('flota')
            ->sidebarWidth('15rem')
            ->default()
            ->sidebarCollapsibleOnDesktop()
            ->sidebarFullyCollapsibleOnDesktop()
            ->login()
            ->colors([
                'primary' => Color::hex('#206bc4'),
                'danger' => Color::Red,
                'red' => Color::hex('#ff0303'),
                'amarillo' => Color::hex('#fbff03'),
                'verde' => Color::hex('#03ff1c'),
                'gray' => Color::Zinc,
                'info' => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Amber,
                'orange' => Color::Orange,
                'sidebar' => Color::hex('#fff'),
            ])
            ->databaseNotifications()
            ->plugins([
                FilamentBackgroundsPlugin::make()->imageProvider(
                    MyImages::make()
                        ->directory('images/backgrounds')
                ),
                FilamentEditProfilePlugin::make()
                    ->slug('mi-perfil')
                    ->setTitle('Mi Perfil')
                    ->setNavigationLabel('Perfil')
                    ->setNavigationGroup('Mantenimiento')
                    ->setIcon('heroicon-o-user')
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars', // image will be stored in 'storage/app/public/avatars
                        rules: 'mimes:jpeg,png|max:3024' //only accept jpeg and png files with a maximum size of 1MB
                    ),
                FilamentSpatieRolesPermissionsPlugin::make(),
                ActivitylogPlugin::make()->navigationGroup('Mantenimiento')->label('Registro')
                    ->pluralLabel('Registros')->authorize(
                        fn() => auth()->user()->cargo === 'Administrador'
                    ),

                /*       TwoFactorAuthPlugin::make()
                       ->forced(),*/
            ])
            ->brandLogo(asset('images/logo222.svg'))
            ->favicon(asset('images/logocheques.svg'))
            ->discoverResources(in: app_path('Filament/Flota/Resources'), for: 'App\\Filament\\Flota\\Resources')
            ->discoverPages(in: app_path('Filament/Flota/Pages'), for: 'App\\Filament\\Flota\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->resources([
                UserResource::class,
                ListaChequeoResource::class,
                BosemResource::class,
                ElementosambResource::class,
                HerramientasambResource::class,
                AmbulanciaResource::class,
                CuponResource::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Flota/Widgets'), for: 'App\\Filament\\Flota\\Widgets')
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
                Authenticate::class,
            ]);
    }
}
