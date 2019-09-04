<?php

namespace Nova\Users\Providers;

use Nova\Users\Models\User;
use Nova\Users\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners\GeneratePassword;
use Illuminate\Database\Eloquent\Relations\Relation;

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

        Event::listen(UserCreatedByAdmin::class, GeneratePassword::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Relation::morphMap([
            'users' => User::class,
        ]);
    }
}
