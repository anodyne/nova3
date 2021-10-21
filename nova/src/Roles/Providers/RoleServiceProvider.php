<?php

declare(strict_types=1);

namespace Nova\Roles\Providers;

use Nova\DomainServiceProvider;
use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Livewire\ManageUsers;
use Nova\Roles\Livewire\SelectPermissionsModal;
use Nova\Roles\Livewire\SelectRolesModal;
use Nova\Roles\Models\Role;
use Nova\Roles\Policies\RolePolicy;

class RoleServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'roles:manage-permissions' => ManagePermissions::class,
            'roles:manage-users' => ManageUsers::class,
            'roles:select-permissions-modal' => SelectPermissionsModal::class,
            'roles:select-roles-modal' => SelectRolesModal::class,
        ];
    }

    public function policies(): array
    {
        return [
            Role::class => RolePolicy::class,
        ];
    }
}
