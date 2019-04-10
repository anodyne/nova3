<?php

namespace Nova\Roles\Events;

use Silber\Bouncer\Database\Role;
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
