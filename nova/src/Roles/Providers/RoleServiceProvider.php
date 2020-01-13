<?php

namespace Nova\Roles\Providers;

use Nova\Roles\Models\Role;
use Nova\DomainServiceProvider;
use Nova\Roles\Policies\RolePolicy;

class RoleServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Role::class => RolePolicy::class,
    ];
}
