<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class SetUserCharacters
{
    use AsAction;

    public function handle(User $user, array $characters): User
    {
        $user->characters()->sync($characters);

        return $user->refresh();
    }
}
