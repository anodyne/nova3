<?php

namespace Nova\Roles\Actions;

use Nova\Foundation\Action;
use Nova\Roles\Models\Role;
use Nova\Foundation\WordGenerator;

class DuplicateRole extends Action
{
    public $errorMessage = 'There was a problem duplicating the role';

    public function execute(Role $originalRole): Role
    {
        return $this->call(function () use ($originalRole) {
            $role = $originalRole->replicate();

            $role->name = implode('-', (new WordGenerator)->words(2));
            $role->display_name = "Copy of {$role->display_name}";

            $role->save();

            $role->syncPermissions($originalRole->permissions);

            return $role->refresh();
        });
    }
}
