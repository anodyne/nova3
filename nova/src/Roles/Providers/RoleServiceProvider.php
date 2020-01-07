<?php

namespace Nova\Roles\Providers;

use Nova\Roles\Models\Role;
use Nova\DomainServiceProvider;
use Nova\Roles\Events\RoleCreated;
use Nova\Roles\Events\RoleUpdated;
use Nova\Roles\Policies\RolePolicy;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Listeners\RefreshPermissionsCache;

class RoleServiceProvider extends DomainServiceProvider
{
    protected $listeners = [
        RoleCreated::class => [
            RefreshPermissionsCache::class,
        ],
        RoleDuplicated::class => [
            RefreshPermissionsCache::class,
        ],
        RoleUpdated::class => [
            RefreshPermissionsCache::class,
        ],
    ];

    protected $policies = [
        Role::class => RolePolicy::class,
    ];
}
