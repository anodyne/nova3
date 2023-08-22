<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleUsersData;
use Nova\Roles\Models\Role;

class AssignRoleUsers
{
    use AsAction;

    public function handle(Role $role, RoleUsersData $data): Role
    {
        $role->user()->sync($data->users);

        return $role->refresh();
    }
}
