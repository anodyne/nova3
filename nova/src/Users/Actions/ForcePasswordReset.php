<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Users\Models\User;

class ForcePasswordReset extends Action
{
    public function handle(User $user): User
    {
        return tap($user)->update([
            'force_password_reset' => true,
        ]);
    }
}
