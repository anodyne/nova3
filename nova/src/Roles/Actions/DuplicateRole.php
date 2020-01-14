<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Nova\Foundation\WordGenerator;

class DuplicateRole
{
    public function execute(Role $originalRole): Role
    {
        $role = $originalRole->replicate();

        $role->name = implode('-', (new WordGenerator)->words(2));
        $role->display_name = "Copy of {$role->display_name}";

        $role->save();

        $role->syncPermissions($originalRole->permissions);

        return $role->refresh();
    }
}
