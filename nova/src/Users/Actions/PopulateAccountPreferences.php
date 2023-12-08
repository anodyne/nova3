<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Data\UserPreferences;
use Nova\Users\Models\User;

class PopulateAccountPreferences
{
    use AsAction;

    public function handle(User $user): User
    {
        $user->preferences = new UserPreferences(
            timezone: 'UTC'
        );
        $user->save();

        return $user->refresh();
    }
}
