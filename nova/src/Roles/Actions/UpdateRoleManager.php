<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\UpdateRoleRequest;

class UpdateRoleManager
{
    use AsAction;

    public function handle(Role $role, UpdateRoleRequest $request): Role
    {
        $role = UpdateRole::run($role, $request->getRoleData());

        $role = AssignRolePermissions::run($role, $request->getRolePermissionsData());

        $role = AssignRoleUsers::run($role, $request->getRoleUsersData());

        return $role;
    }
}
