<?php

namespace App\Providers;

use App\Listeners\SendEmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Cart\Events\OrderPlaced;
use Modules\Cart\Listeners\SendOrderPlaceNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerification::class,
        ],
        \App\Events\ForgotPassword::class => [
            \App\Listeners\SendResetPasswordCode::class
        ],
        OrderPlaced::class => [
            SendOrderPlaceNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
