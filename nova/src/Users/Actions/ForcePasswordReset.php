<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class ForcePasswordReset
{
    use AsAction;

    public function handle(User $user): User
    {
        return tap($user)->update([
            'force_password_reset' => true,
        ]);
    }
}
