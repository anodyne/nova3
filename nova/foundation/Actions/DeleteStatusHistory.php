<?php

declare(strict_types=1);

namespace Nova\Foundation\Actions;

use Nova\Users\Models\User;

class DeleteStatusHistory extends Action
{
    public function handle(User $user): void
    {
        $user->statusHistories()->delete();
    }
}
