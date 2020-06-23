<?php

namespace Nova\Roles\Actions;

use Nova\Foundation\Action;
use Nova\Roles\Models\Role;
use Nova\Roles\DataTransferObjects\RoleData;

class CreateRole extends Action
{
    public $errorMessage = 'There was a problem creating the role';

    public function execute(RoleData $data): Role
    {
        return $this->call(function () use ($data) {
            $role = Role::firstOrCreate(
                $data->except('permissions', 'users')->toArray()
            );

            if ($data->permissions) {
                $role->syncPermissions($data->permissions);
            }

            return $role->refresh();
        });
    }
}
