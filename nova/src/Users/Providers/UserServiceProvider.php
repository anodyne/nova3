<?php

namespace Nova\Users\Providers;

use Nova\Users\Events;
use Nova\Users\Listeners;
use Nova\Users\Models\User;
use Nova\Users\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::policy(User::class, UserPolicy::class);

        Event::listen(Events\AdminCreated::class, Listeners\GeneratePassword::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
