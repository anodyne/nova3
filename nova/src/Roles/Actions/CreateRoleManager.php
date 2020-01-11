<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class CreateRoleManager
{
    /**
     * @var  CreateRole
     */
    protected $createRole;

    /**
     * @var  UpdateUserRoles
     */
    protected $updateUserRoles;

    public function __construct(
        CreateRole $createRole,
        UpdateUsersRoles $updateUsersRoles
    ) {
        $this->createRole = $createRole;
        $this->updateUsersRoles = $updateUsersRoles;
    }

    public function execute(Request $request): Role
    {
        $role = $this->createRole->execute(RoleData::fromRequest($request));

        $data = RoleAssignmentData::fromRequest($request);
        $data->role = $role;

        $this->updateUsersRoles->execute($data);

        return $role->refresh();
    }
}
