<?php

namespace Nova\Roles\Actions;

use Nova\Foundation\Action;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateUsersRoles extends Action
{
    public $errorMessage = 'There was a problem updating users roles';

    public function execute(RoleAssignmentData $data)
    {
        return $this->call(function () use ($data) {
            $data->role->users->diff($data->users)->each->detachRole($data->role);

            $data->users->diff($data->role->users)->each->attachRole($data->role);
        });
    }
}
