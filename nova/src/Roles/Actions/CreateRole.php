<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Role;

class CreateRole
{
    use AsAction;

    public function handle(RoleData $data): Role
    {
        $role = Role::firstOrCreate(
            $data->except('permissions', 'users')->toArray()
        );

        if ($data->permissions) {
            $role->syncPermissions($data->permissions);
        }

        return $role->refresh();
    }
}
