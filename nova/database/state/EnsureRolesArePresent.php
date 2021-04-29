<?php

namespace Database\State;

use Nova\Roles\Models\Role;

class EnsureRolesArePresent
{
    public function __invoke()
    {
        if ($this->present()) {
            return;
        }

        Role::unguarded(function () {
            collect([
                ['name' => 'admin', 'display_name' => 'System Admin', 'locked' => true, 'sort' => 0],
                ['name' => 'user', 'display_name' => 'Active User', 'default' => true, 'sort' => 1],
            ])->each([Role::class, 'create']);
        });
    }

    private function present(): bool
    {
        return Role::count() > 0;
    }
}
