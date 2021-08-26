<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Nova\Foundation\WordGenerator;
use Nova\Roles\Models\Role;

class DuplicateRole
{
    public function execute(Role $originalRole): Role
    {
        $role = $originalRole->replicate();

        $role->name = implode('-', (new WordGenerator())->words(2));
        $role->display_name = "Copy of {$role->display_name}";

        $role->save();

        $role->syncPermissions($originalRole->permissions);

        return $role->refresh();
    }
}
