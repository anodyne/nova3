<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\StoreRoleRequest;

class CreateRoleManager extends Action
{
    public function handle(StoreRoleRequest $request): Role
    {
        return DB::transaction(function () use ($request) {
            $role = CreateRole::run($request->getRoleData());

            $role = AssignRolePermissions::run($role, $request->getRolePermissionsData());

            return AssignRoleUsers::run($role, $request->getRoleUsersData());
        });
    }
}
