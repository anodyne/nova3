<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Roles\Models\Role;
use Nova\Users\Data\AssignUserRolesData;
use Nova\Users\Models\User;

class SyncUserRoles extends Action
{
    public function handle(User $user, AssignUserRolesData $data): User
    {
        $roles = Role::findMany($data->roles, ['id'])->all();

        $user->syncRoles($roles);

        return $user->refresh();
    }
}
