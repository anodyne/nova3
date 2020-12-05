<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;

class ReorderRoles
{
    public function execute($sort): void
    {
        collect(explode(',', $sort))->each(function ($roleId, $index) {
            Role::where('id', $roleId)->update(['sort' => $index]);
        });
    }
}
