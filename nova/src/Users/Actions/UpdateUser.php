<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Users\DataTransferObjects\UserData;

class UpdateUser
{
    public function execute(User $user, UserData $data): User
    {
        return tap($user)->update($data->except('roles')->all())->refresh();
    }
}
