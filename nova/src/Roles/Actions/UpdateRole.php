<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Nova\Roles\DataTransferObjects\RoleData;

class UpdateRole
{
    public function execute(Role $role, RoleData $data): Role
    {
        $updateData = ($role->locked)
            ? $data->except('name')
            : $data;

        $role->update($updateData->toArray());

        if ($data->permissions) {
            $role->syncPermissions($data->permissions);
        }

        return $role->refresh();
    }
}
