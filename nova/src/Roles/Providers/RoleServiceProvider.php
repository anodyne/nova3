<?php

namespace Nova\Roles\Providers;

use Nova\Roles\Models\Role;
use Nova\Roles\Events\RoleCreated;
use Nova\Roles\Events\RoleDeleted;
use Nova\Roles\Events\RoleUpdated;
use Nova\Roles\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleDuplicated;
use Illuminate\Support\ServiceProvider;
use Nova\Roles\Listeners\RefreshPermissionsCache;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerEventListeners();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    protected function registerPolicies()
    {
        Gate::policy(Role::class, RolePolicy::class);
    }

    protected function registerEventListeners()
    {
        Event::listen(RoleCreated::class, RefreshPermissionsCache::class);
        Event::listen(RoleUpdated::class, RefreshPermissionsCache::class);
        Event::listen(RoleDeleted::class, RefreshPermissionsCache::class);
        Event::listen(RoleDuplicated::class, RefreshPermissionsCache::class);
    }
}
