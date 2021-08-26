<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Role;

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
