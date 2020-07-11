<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Nova\Roles\DataTransferObjects\RoleData;

class CreateRole
{
    public function execute(RoleData $data): Role
    {
        $role = Role::firstOrCreate(
            $data->except('permissions', 'users')->toArray()
        );

        if ($data->permissions) {
            $role->syncPermissions($data->permissions);
        }

        return $role->refresh();
    }
}
