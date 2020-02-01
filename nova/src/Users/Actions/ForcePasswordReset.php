<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;

class ForcePasswordReset
{
    public function execute(User $user): User
    {
        return tap($user)->update([
            'force_password_reset' => true,
        ]);
    }
}
