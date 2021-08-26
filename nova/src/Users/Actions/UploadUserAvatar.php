<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Users\Models\User;

class UploadUserAvatar
{
    public function execute(User $user, $imagePath): User
    {
        if ($imagePath !== null) {
            $user->addMedia($imagePath)->toMediaCollection('avatar');
        }

        return $user->refresh();
    }
}
