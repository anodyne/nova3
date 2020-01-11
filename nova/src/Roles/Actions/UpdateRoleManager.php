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
    protected $updateUserRoles;

    public function __construct(
        UpdateRole $updateRole,
        UpdateUsersRoles $updateUsersRoles
    ) {
        $this->updateRole = $updateRole;
        $this->updateUsersRoles = $updateUsersRoles;
    }

    public function execute(Role $role, Request $request): Role
    {
        $this->updateRole->execute($role, RoleData::fromRequest($request));

        $this->updateUsersRoles->execute(
            RoleAssignmentData::fromRequest($request)
        );

        return $role->refresh();
    }
}
