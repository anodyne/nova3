<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Role;

class UpdateRoleManager
{
    use AsAction;

    public function handle(Role $role, Request $request): Role
    {
        UpdateRole::run($role, RoleData::fromRequest($request));

        UpdateRoleUsers::run(
            RoleAssignmentData::fromRequest($request)
        );

        return $role->refresh();
    }
}
