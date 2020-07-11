<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;

class DeleteRole
{
    public function execute(Role $role): Role
    {
        return tap($role)->delete();
    }
}
