<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Nova\Roles\Models\Permission;
use Nova\Roles\DataTransferObjects\RoleData;

class CreateRole
{
    public function execute(RoleData $data): Role
    {
        $role = Role::firstOrCreate(
            $data->only('name', 'display_name')->toArray()
        );

        $permissions = collect($data->permissions)->map(function ($permission) {
            return Permission::firstOrCreate(['name' => $permission]);
        });

        $role->syncPermissions($permissions);

        return $role->refresh();
    }
}
