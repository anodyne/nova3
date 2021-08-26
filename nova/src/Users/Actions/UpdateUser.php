<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Users\DataTransferObjects\UserData;
use Nova\Users\Models\User;

class UpdateUser
{
    public function execute(User $user, UserData $data): User
    {
        return tap($user)
            ->update($data->except('roles')->toArray())
            ->fresh();
    }
}
