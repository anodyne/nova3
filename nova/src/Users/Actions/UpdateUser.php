<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Data\UserData;
use Nova\Users\Models\User;

class UpdateUser
{
    use AsAction;

    public function handle(User $user, UserData $data): User
    {
        return tap($user)
            ->update($data->all())
            ->refresh();
    }
}
