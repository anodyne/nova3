<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Roles\Data\RoleUsersData;
use Nova\Roles\Models\Role;

class AssignRoleUsers extends Action
{
    public function handle(Role $role, RoleUsersData $data): Role
    {
        $role->user()->sync($data->users);

        return $role->refresh();
    }
}
