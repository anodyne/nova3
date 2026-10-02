<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Users\Data\UserData;
use Nova\Users\Models\User;

class UpdateUser extends Action
{
    public function handle(User $user, UserData $data): User
    {
        return tap($user)
            ->update($data->toArray())
            ->refresh();
    }
}
