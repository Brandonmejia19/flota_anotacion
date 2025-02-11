<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Fortify\Events\TwoFactorAuthenticationEnabled;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Vormkracht10\TwoFactorAuth\Listeners\SendTwoFactorCodeListener;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TwoFactorAuthenticationChallenged::class => [
            SendTwoFactorCodeListener::class,
        ],
        TwoFactorAuthenticationEnabled::class => [
            SendTwoFactorCodeListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen([
            TwoFactorAuthenticationChallenged::class,
            TwoFactorAuthenticationEnabled::class
        ], SendTwoFactorCodeListener::class);    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
