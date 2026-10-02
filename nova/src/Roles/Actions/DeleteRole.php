<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Roles\Models\Role;

class DeleteRole extends Action
{
    public function handle(Role $role): Role
    {
        if (! $role->is_locked) {
            return tap($role)->delete();
        }

        return $role;
    }
}
