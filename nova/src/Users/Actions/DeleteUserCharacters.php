<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;

class DeleteUserCharacters
{
    public function execute(User $user): User
    {
        $user->characters->each->delete();

        return $user->refresh();
    }
}
