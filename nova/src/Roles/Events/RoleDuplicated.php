<?php

namespace Nova\Roles\Events;

use Nova\Roles\Models\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RoleDuplicated
{
    use Dispatchable, SerializesModels;

    public $role;

    public $originalRole;

    public function __construct(Role $role, Role $originalRole)
    {
        $this->role = $role;
        $this->originalRole = $originalRole;
    }
}
