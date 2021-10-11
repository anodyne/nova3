<?php

declare(strict_types=1);

namespace Nova\Users\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Users\Models\User;

class UserUpdatedByAdmin
{
    use Dispatchable;
    use SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
