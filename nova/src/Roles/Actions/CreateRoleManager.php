<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleAssignmentData;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;

class CreateRoleManager
{
    use AsAction;

    public function handle(Request $request): Role
    {
        $role = CreateRole::run(RoleData::from($request));

        $data = RoleAssignmentData::from($request);
        $data->role = $role;

        UpdateRoleUsers::run($data);

        return $role->refresh();
    }
}
