<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Users\DataTransferObjects\UserData;

class UpdateUser
{
    public function execute(User $user, UserData $data)
    {
        return tap($user, function ($user) use ($data) {
            $user->update($data->toArray());
        })->refresh();
    }
}
