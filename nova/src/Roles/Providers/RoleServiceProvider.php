<?php

declare(strict_types=1);

namespace Nova\Roles\Providers;

use Nova\DomainServiceProvider;
use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Livewire\ManageUsers;
use Nova\Roles\Livewire\PermissionsList;
use Nova\Roles\Livewire\RolesList;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Roles\Spotlight\AddRole;
use Nova\Roles\Spotlight\EditRole;
use Nova\Roles\Spotlight\ViewRole;
use Nova\Roles\Spotlight\ViewRoles;

class RoleServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'permissions-list' => PermissionsList::class,
            'roles-list' => RolesList::class,
            'roles-manage-permissions' => ManagePermissions::class,
            'roles-manage-users' => ManageUsers::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'permission' => Permission::class,
            'role' => Role::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'role_' => Role::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            AddRole::class,
            EditRole::class,
            ViewRole::class,
            ViewRoles::class,
        ];
    }
}
