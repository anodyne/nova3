<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateRoleManager
{
    /**
     * @var  UpdateRole
     */
    protected $updateRole;

    /**
     * @var  UpdateUserRoles
     */
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
