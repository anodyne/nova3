<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;

class DuplicateRole
{
    use AsAction;

    public function handle(Role $original, RoleData $data): Role
    {
        if (! $original->is_locked) {
            return DB::transaction(function () use ($original, $data) {
                $role = $original->replicate([
                    'active_users_count',
                    'inactive_users_count',
                    'user_count',
                    'permissions_count',
                    'prefixed_id',
                ]);
                $role->fill($data->toArray());
                $role->save();

                $role->syncPermissions($original->permissions);

                activity()
                    ->performedOn($original)
                    ->event('duplicated')
                    ->log('duplicated');

                return $role->refresh();
            });
        }

        return $original;
    }
}
