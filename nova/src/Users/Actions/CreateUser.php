<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Users\DataTransferObjects\UserData;

class CreateUser
{
    public function execute(UserData $data): User
    {
        $user = User::create($data->except('roles')->all());

        $data->roles->each->giveToUser($user);

        return $user->refresh();
    }
}
