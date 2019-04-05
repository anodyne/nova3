<?php

namespace Nova\Foundation\Providers;

use Nova\Themes\Theme;
use Silber\Bouncer\Database\Role;
use Nova\Themes\Policies\ThemePolicy;
use Nova\Authorization\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        Theme::class => ThemePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
