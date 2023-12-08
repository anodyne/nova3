<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Models\Role;

class DeleteRole
{
    use AsAction;

    public function handle(Role $role): Role
    {
        if (! $role->is_locked) {
            return tap($role)->delete();
        }

        return $role;
    }
}
