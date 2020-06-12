<?php

namespace Nova\Roles\Actions;

use Nova\Foundation\Action;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateRoleUsers extends Action
{
    public $errorMessage = 'There was a problem updating users roles';

    public function execute(RoleAssignmentData $data)
    {
        return $this->call(function () use ($data) {
            $data->role->users()->sync($data->users);
        });
    }
}
