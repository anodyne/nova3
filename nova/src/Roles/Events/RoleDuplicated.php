<?php

namespace Nova\Roles\Events;

use Nova\Roles\Models\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RoleDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public $originalRole;

    public $role;

    public function __construct(Role $role, Role $originalRole)
    {
        $this->originalRole = $originalRole;
        $this->role = $role;
    }
}
