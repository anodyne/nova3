<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Role;

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
