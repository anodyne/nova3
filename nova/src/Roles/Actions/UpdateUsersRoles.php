<?php

namespace Nova\Roles\Actions;

use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateUsersRoles
{
    public function execute(RoleAssignmentData $data)
    {
        $data->role->users->diff($data->users)->each->detachRole($data->role);

        $data->users->diff($data->role->users)->each->attachRole($data->role);
    }
}
