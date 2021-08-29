<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\WordGenerator;
use Nova\Roles\Models\Role;

class DuplicateRole
{
    use AsAction;

    public function handle(Role $original): Role
    {
        $role = $original->replicate();

        $role->name = implode('-', (new WordGenerator())->words(2));
        $role->display_name = "Copy of {$role->display_name}";

        $role->save();

        $role->syncPermissions($original->permissions);

        return $role->refresh();
    }
}
