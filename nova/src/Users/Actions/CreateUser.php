<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Users\Models\States\Active;
use Nova\Users\DataTransferObjects\UserData;

class CreateUser
{
    public function execute(UserData $data): User
    {
        $user = User::create(array_merge(
            $data->except('roles')->toArray(),
            ['status' => Active::class]
        ));

        $data->roles->each->giveToUser($user);

        return $user->fresh();
    }
}
