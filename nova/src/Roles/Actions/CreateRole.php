<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;

class CreateRole
{
    use AsAction;

    public function handle(RoleData $data): Role
    {
        $role = Role::firstOrCreate(
            Arr::except($data->all(), ['permissions', 'users'])
        );

        if ($data->permissions) {
            $role->syncPermissions($data->permissions);
        }

        return $role->refresh();
    }
}
