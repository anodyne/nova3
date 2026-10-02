<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Users\Data\UserModerations;
use Nova\Users\Models\User;

class PopulateUserModerations extends Action
{
    public function handle(User $user): User
    {
        $user->update([
            'moderations' => UserModerations::from(
                announcements: false,
                posts: false
            ),
        ]);

        return $user->refresh();
    }
}
