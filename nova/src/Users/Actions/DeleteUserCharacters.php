<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Users\Models\User;

class DeleteUserCharacters extends Action
{
    public function handle(User $user): void
    {
        $user->characters()->delete();
    }
}
