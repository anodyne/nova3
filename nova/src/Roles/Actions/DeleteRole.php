<?php

namespace Nova\Roles\Actions;

use Nova\Foundation\Action;
use Nova\Roles\Models\Role;

class DeleteRole extends Action
{
    public $errorMessage = 'There was a problem deleting the role';

    public function execute(Role $role): Role
    {
        return $this->call(function () use ($role) {
            return tap($role)->delete();
        });
    }
}
