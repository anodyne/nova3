<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;

class UploadUserAvatar
{
    public function execute(User $user, $image): User
    {
        if ($image !== null) {
            $user->addMedia($image)->toMediaCollection('avatar');
        }

        return $user->refresh();
    }
}
