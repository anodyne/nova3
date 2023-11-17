<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Data\AssignUserRolesData;
use Nova\Users\Models\User;

class SyncUserRoles
{
    use AsAction;

    public function handle(User $user, AssignUserRolesData $data): User
    {
        $user->syncRoles($data->roles);

        return $user->refresh();
    }
}
