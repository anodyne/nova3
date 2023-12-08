<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;

class UpdateRole
{
    use AsAction;

    public function handle(Role $role, RoleData $data): Role
    {
        $role->update(
            $data->exceptWhen('name', $role->is_locked)->all()
        );

        return $role->refresh();
    }
}
