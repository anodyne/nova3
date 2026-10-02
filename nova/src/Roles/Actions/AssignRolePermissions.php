<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Roles\Data\RolePermissionsData;
use Nova\Roles\Models\Role;

class AssignRolePermissions extends Action
{
    public function handle(Role $role, RolePermissionsData $data): Role
    {
        $role->permissions()->sync($data->permissions);

        return $role->refresh();
    }
}
