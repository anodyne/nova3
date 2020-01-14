<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Nova\Roles\Models\Permission;
use Nova\Roles\DataTransferObjects\RoleData;

class UpdateRole
{
    public function execute(Role $role, RoleData $data): Role
    {
        $role->update($data->except('permissions')->toArray());

        $permissions = collect($data->permissions)->map(function ($permission) {
            return Permission::firstOrCreate(['name' => $permission]);
        });

        $role->syncPermissions($permissions);

        return $role->refresh();
    }
}
