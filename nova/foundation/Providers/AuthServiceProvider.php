<?php

namespace Nova\Foundation\Providers;

use Nova\Roles\Models\Role;
use Nova\Roles\Models\Ability;
use Illuminate\Cache\ArrayStore;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Nova\Foundation\Bouncer\AdvancedCachedClipboard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Bouncer::cache();

        Bouncer::setClipboard(new AdvancedCachedClipboard(new ArrayStore));

        Bouncer::useRoleModel(Role::class);
        Bouncer::useAbilityModel(Ability::class);

        $this->registerPolicies();
    }
}
