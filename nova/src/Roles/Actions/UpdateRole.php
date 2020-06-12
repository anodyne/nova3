<?php

namespace Nova\Roles\Actions;

use Nova\Foundation\Action;
use Nova\Roles\Models\Role;
use Nova\Roles\Models\Permission;
use Nova\Roles\DataTransferObjects\RoleData;

class UpdateRole extends Action
{
    public $errorMessage = 'There was a problem updating the role.';

    public function execute(Role $role, RoleData $data): Role
    {
        return $this->call(function () use ($role, $data) {
            $updateData = ($role->locked)
                ? $data->except('name')
                : $data;

            $role->update($updateData->toArray());

            $role->syncPermissions($data->permissions);

            return $role->refresh();
        });
    }
}
