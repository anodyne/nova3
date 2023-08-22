<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;

class DuplicateRole
{
    use AsAction;

    public function handle(Role $original, RoleData $data): Role
    {
        if (! $original->locked) {
            $role = $original->replicate(['active_users_count', 'inactive_users_count']);
            $role->fill($data->all());
            $role->save();

            $role->syncPermissions($original->permissions);
        }

        return $role->refresh();
    }
}
