<?php

declare(strict_types=1);

namespace Nova\Roles\Providers;

use Nova\DomainServiceProvider;
use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Livewire\ManageRoles;
use Nova\Roles\Models\Role;
use Nova\Roles\Policies\RolePolicy;
use Nova\Roles\Responses\CreateRoleResponse;
use Nova\Roles\Responses\DeleteRoleResponse;
use Nova\Roles\Responses\ShowAllRolesResponse;
use Nova\Roles\Responses\ShowRoleResponse;
use Nova\Roles\Responses\UpdateRoleResponse;

class RoleServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'roles:manage-permissions' => ManagePermissions::class,
        'roles:manage-roles' => ManageRoles::class,
    ];

    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    protected $responsables = [
        CreateRoleResponse::class,
        DeleteRoleResponse::class,
        UpdateRoleResponse::class,
        ShowAllRolesResponse::class,
        ShowRoleResponse::class,
    ];
}
