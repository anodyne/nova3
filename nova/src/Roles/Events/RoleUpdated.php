<?php

declare(strict_types=1);

namespace Nova\Roles\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Roles\Models\Role;

class RoleUpdated
{
    use Dispatchable;
    use SerializesModels;

    public Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}
