<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleAssignmentData;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;

class UpdateRoleManager
{
    use AsAction;

    public function handle(Role $role, Request $request): Role
    {
        UpdateRole::run($role, RoleData::from($request));

        UpdateRoleUsers::run(
            RoleAssignmentData::from($request)
        );

        return $role->refresh();
    }
}
