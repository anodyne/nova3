<?php

namespace Nova\Roles\Events;

use Nova\Roles\Models\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}
