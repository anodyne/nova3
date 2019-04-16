<?php

namespace Nova\Users\Providers;

use Nova\Users\Events;
use Nova\Users\Listeners;
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
        $this->app['events']->listen(Events\AdminCreated::class, Listeners\GeneratePassword::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
