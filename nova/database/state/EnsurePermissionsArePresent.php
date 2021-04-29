<?php

namespace Database\State;

use Nova\Roles\Models\Permission;

class EnsurePermissionsArePresent
{
    public function __invoke()
    {
        if ($this->present()) {
            return;
        }

        Permission::unguarded(function () {
            collect([
                ['name' => 'role.create', 'display_name' => 'Create roles'],
                ['name' => 'role.delete', 'display_name' => 'Delete roles'],
                ['name' => 'role.update', 'display_name' => 'Update roles'],
                ['name' => 'role.view', 'display_name' => 'View roles'],

                ['name' => 'theme.create', 'display_name' => 'Create themes'],
                ['name' => 'theme.delete', 'display_name' => 'Delete themes'],
                ['name' => 'theme.update', 'display_name' => 'Update themes'],
                ['name' => 'theme.view', 'display_name' => 'View themes'],

                ['name' => 'user.create', 'display_name' => 'Create users'],
                ['name' => 'user.delete', 'display_name' => 'Delete users'],
                ['name' => 'user.update', 'display_name' => 'Update users'],
                ['name' => 'user.view', 'display_name' => 'View users'],

                ['name' => 'rank.create', 'display_name' => 'Create ranks'],
                ['name' => 'rank.delete', 'display_name' => 'Delete ranks'],
                ['name' => 'rank.update', 'display_name' => 'Update ranks'],
                ['name' => 'rank.view', 'display_name' => 'View ranks'],

                ['name' => 'department.create', 'display_name' => 'Create departments and positions'],
                ['name' => 'department.delete', 'display_name' => 'Delete departments and positions'],
                ['name' => 'department.update', 'display_name' => 'Update departments and positions'],
                ['name' => 'department.view', 'display_name' => 'View departments and positions'],

                ['name' => 'character.create', 'display_name' => 'Create characters'],
                ['name' => 'character.delete', 'display_name' => 'Delete characters'],
                ['name' => 'character.update', 'display_name' => 'Update characters'],
                ['name' => 'character.view', 'display_name' => 'View characters'],

                ['name' => 'story.create', 'display_name' => 'Create stories'],
                ['name' => 'story.delete', 'display_name' => 'Delete stories'],
                ['name' => 'story.update', 'display_name' => 'Update stories'],
                ['name' => 'story.view', 'display_name' => 'View stories'],

                ['name' => 'post.create', 'display_name' => 'Create posts'],
                ['name' => 'post.delete', 'display_name' => 'Delete posts'],
                ['name' => 'post.update', 'display_name' => 'Update posts'],
                ['name' => 'post.view', 'display_name' => 'View posts'],
            ])->each([Permission::class, 'create']);
        });
    }

    private function present(): bool
    {
        return Permission::count() > 0;
    }
}
