<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Role;

class CreateRoleManager
{
    use AsAction;

    public function handle(Request $request): Role
    {
        $role = CreateRole::run(RoleData::fromRequest($request));

        $data = RoleAssignmentData::fromRequest($request);
        $data->role = $role;

        UpdateRoleUsers::run($data);

        return $role->refresh();
    }
}
