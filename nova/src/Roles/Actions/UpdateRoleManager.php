<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Http\Request;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Models\Role;

class UpdateRoleManager
{
    protected $updateRole;

    protected $updateRoleUsers;

    public function __construct(
        UpdateRole $updateRole,
        UpdateRoleUsers $updateRoleUsers
    ) {
        $this->updateRole = $updateRole;
        $this->updateRoleUsers = $updateRoleUsers;
    }

    public function execute(Role $role, Request $request): Role
    {
        $this->updateRole->execute($role, RoleData::fromRequest($request));

        $this->updateRoleUsers->execute(
            RoleAssignmentData::fromRequest($request)
        );

        return $role->refresh();
    }
}
