<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class DeleteUserCharacters
{
    use AsAction;

    public function handle(User $user): User
    {
        $user->characters->each->delete();

        return $user->refresh();
    }
}
