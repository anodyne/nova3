<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RolePermissionsData;
use Nova\Roles\Models\Role;

class AssignRolePermissions
{
    use AsAction;

    public function handle(Role $role, RolePermissionsData $data): Role
    {
        $role->permissions()->sync($data->permissions);

        return $role->refresh();
    }
}
