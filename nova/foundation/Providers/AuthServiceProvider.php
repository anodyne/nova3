<?php

namespace Nova\Foundation\Providers;

use Bouncer;
use Nova\Themes\Theme;
use Nova\Roles\Models\Role;
use Nova\Roles\Models\Ability;
use Nova\Themes\Policies\ThemePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Theme::class => ThemePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Bouncer::useRoleModel(Role::class);
        Bouncer::useAbilityModel(Ability::class);

        $this->registerPolicies();
    }
}
