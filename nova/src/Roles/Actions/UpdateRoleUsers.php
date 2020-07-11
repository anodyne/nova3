<?php

namespace Nova\Roles\Actions;

use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateRoleUsers
{
    public function execute(RoleAssignmentData $data): void
    {
        $data->role->users()->sync($data->users);
    }
}
