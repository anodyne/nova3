<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\UpdateRoleRequest;
use Spatie\Activitylog\Facades\LogBatch;

class UpdateRoleManager
{
    use AsAction;

    public function handle(Role $role, UpdateRoleRequest $request): Role
    {
        return DB::transaction(function () use ($role, $request) {
            LogBatch::startBatch();

            $role = UpdateRole::run($role, $request->getRoleData());

            $role = AssignRolePermissions::run($role, $request->getRolePermissionsData());

            $role = AssignRoleUsers::run($role, $request->getRoleUsersData());

            LogBatch::endBatch();

            return $role;
        });
    }
}
