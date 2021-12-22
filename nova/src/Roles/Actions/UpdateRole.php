<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;

class UpdateRole
{
    use AsAction;

    public function handle(Role $role, RoleData $data): Role
    {
        $updateData = ($role->locked)
            ? Arr::except($data->all(), 'name')
            : $data->all();

        $role->update($updateData);

        return $role->refresh();
    }
}
