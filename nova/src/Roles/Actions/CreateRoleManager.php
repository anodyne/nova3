<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\StoreRoleRequest;

class CreateRoleManager
{
    use AsAction;

    public function handle(StoreRoleRequest $request): Role
    {
        $role = CreateRole::run($request->getRoleData());

        $role = AssignRolePermissions::run($role, $request->getRolePermissionsData());

        $role = AssignRoleUsers::run($role, $request->getRoleUsersData());

        return $role;
    }
}
