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
        if (! $original->is_locked) {
            $replica = $original->replicate([
                'active_users_count',
                'inactive_users_count',
                'user_count',
                'permissions_count',
                'prefixed_id',
            ]);
            $replica->fill($data->all());
            $replica->save();

            $replica->syncPermissions($original->permissions);
        }

        return $replica->refresh();
    }
}
