<?php

namespace Nova\Authorization\Events;

use Silber\Bouncer\Database\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RoleDeleted
{
    use Dispatchable, SerializesModels;

    public $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}
