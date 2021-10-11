<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Role;

class UpdateRole
{
    use AsAction;

    public function handle(Role $role, RoleData $data): Role
    {
        $updateData = ($role->locked)
            ? $data->except('name')
            : $data;

        $role->update($updateData->toArray());

        if ($data->permissions) {
            $role->syncPermissions($data->permissions);
        }

        return $role->refresh();
    }
}
