<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Data\UserModerations;
use Nova\Users\Models\User;

class PopulateUserModerations
{
    use AsAction;

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
