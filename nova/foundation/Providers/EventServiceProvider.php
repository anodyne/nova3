<?php

declare(strict_types=1);

namespace Nova\Foundation\Providers;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lab404\Impersonate\Events\LeaveImpersonation;
use Lab404\Impersonate\Events\TakeImpersonation;

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
        Authenticated::class => [
            \Nova\Users\Listeners\CheckForForcedPasswordReset::class,
        ],
        Login::class => [
            \Nova\Users\Listeners\RecordLoginTime::class,
        ],
        LeaveImpersonation::class => [
            \Nova\Foundation\Listeners\LogImpersonationEnd::class,
        ],
        TakeImpersonation::class => [
            \Nova\Foundation\Listeners\LogImpersonationStart::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
