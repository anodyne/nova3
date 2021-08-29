<?php

declare(strict_types=1);

namespace Nova\Roles\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Roles\Models\Role;

class RoleDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public Role $original;

    public Role $role;

    public function __construct(Role $role, Role $original)
    {
        $this->original = $original;
        $this->role = $role;
    }
}
