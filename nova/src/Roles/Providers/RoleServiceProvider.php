<?php

declare(strict_types=1);

namespace Nova\Roles\Providers;

use Nova\DomainServiceProvider;
use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Livewire\ManageUsers;
use Nova\Roles\Livewire\RolesList;
use Nova\Roles\Livewire\SelectPermissionsModal;
use Nova\Roles\Livewire\SelectRolesModal;

class RoleServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'roles:list' => RolesList::class,
            'roles:manage-permissions' => ManagePermissions::class,
            'roles:manage-users' => ManageUsers::class,
            'roles:select-permissions-modal' => SelectPermissionsModal::class,
            'roles:select-roles-modal' => SelectRolesModal::class,
        ];
    }
}
