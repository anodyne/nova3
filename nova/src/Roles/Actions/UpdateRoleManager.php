<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\UpdateRoleRequest;

class UpdateRoleManager extends Action
{
    public function handle(Role $role, UpdateRoleRequest $request): Role
    {
        return DB::transaction(function () use ($role, $request) {
            $role = UpdateRole::run($role, $request->getRoleData());

            $role = AssignRolePermissions::run($role, $request->getRolePermissionsData());

            return AssignRoleUsers::run($role, $request->getRoleUsersData());
        });
    }
}
