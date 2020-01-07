<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;

class DeleteRole
{
    public function execute(Role $role)
    {
        $role->delete();

        return $role;
    }
}
