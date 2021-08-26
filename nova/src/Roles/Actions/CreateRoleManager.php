<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Http\Request;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Role;

class CreateRoleManager
{
    protected $createRole;

    protected $updateRoleUsers;

    public function __construct(
        CreateRole $createRole,
        UpdateRoleUsers $updateRoleUsers
    ) {
        $this->createRole = $createRole;
        $this->updateRoleUsers = $updateRoleUsers;
    }

    public function execute(Request $request): Role
    {
        $role = $this->createRole->execute(RoleData::fromRequest($request));

        $data = RoleAssignmentData::fromRequest($request);
        $data->role = $role;

        $this->updateRoleUsers->execute($data);

        return $role->refresh();
    }
}
