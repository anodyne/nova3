<?php

declare(strict_types=1);

namespace Nova\Roles\Providers;

use Nova\DomainServiceProvider;
use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Livewire\ManageRoles;
use Nova\Roles\Livewire\ManageUsers;
use Nova\Roles\Livewire\SelectPermissionsModal;
use Nova\Roles\Models\Role;
use Nova\Roles\Policies\RolePolicy;
use Nova\Roles\Responses\CreateRoleResponse;
use Nova\Roles\Responses\DeleteRoleResponse;
use Nova\Roles\Responses\ShowAllRolesResponse;
use Nova\Roles\Responses\ShowRoleResponse;
use Nova\Roles\Responses\UpdateRoleResponse;

class RoleServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'roles:manage-permissions' => ManagePermissions::class,
            'roles:manage-users' => ManageUsers::class,
            'roles:manage-roles' => ManageRoles::class,
            'roles:select-permissions-modal' => SelectPermissionsModal::class,
        ];
    }

    public function policies(): array
    {
        return [
            Role::class => RolePolicy::class,
        ];
    }

    public function responsables(): array
    {
        return [
            CreateRoleResponse::class,
            DeleteRoleResponse::class,
            UpdateRoleResponse::class,
            ShowAllRolesResponse::class,
            ShowRoleResponse::class,
        ];
    }
}
