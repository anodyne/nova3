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

    public function __construct(
        public Role $role,
        public Role $original
    ) {}
}
