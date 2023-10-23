<?php

declare(strict_types=1);

namespace Nova\Users\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Users\Models\User;

class UserDeactivated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public User $user
    ) {
    }
}
