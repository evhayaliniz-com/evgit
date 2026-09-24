<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \Illuminate\Auth\Events\Registered::class => [
            \App\Listeners\SendWelcomeEmail::class,
            \App\Listeners\SendAdminNotificationOnRegistration::class,
        ],

        \App\Events\UserLoggedIn::class => [
            \App\Listeners\SendLoginNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
