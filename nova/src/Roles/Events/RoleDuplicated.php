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

    public $originalRole;

    public $role;

    public function __construct(Role $role, Role $originalRole)
    {
        $this->originalRole = $originalRole;
        $this->role = $role;
    }
}
