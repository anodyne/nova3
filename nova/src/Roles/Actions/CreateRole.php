<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;

class CreateRole
{
    use AsAction;

    public function handle(RoleData $data): Role
    {
        return Role::create($data->all());
    }
}
