<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Models\Role;

class ReorderRoles
{
    use AsAction;

    public function handle($sort): void
    {
        collect(explode(',', $sort))->each(function ($roleId, $index) {
            Role::where('id', $roleId)->update(['sort' => $index]);
        });
    }
}
