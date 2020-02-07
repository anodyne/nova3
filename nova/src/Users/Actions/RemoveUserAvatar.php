<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;

class RemoveUserAvatar
{
    public function execute(User $user, bool $removeAvatar = false): User
    {
        if ($removeAvatar) {
            $user->clearMediaCollection('avatar');
        }

        return $user->refresh();
    }
}
