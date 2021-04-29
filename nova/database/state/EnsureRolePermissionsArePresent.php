<?php

namespace Database\State;

use Illuminate\Support\Facades\DB;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

class EnsureRolePermissionsArePresent
{
    public function __invoke()
    {
        if ($this->present()) {
            return;
        }

        collect([
            'admin' => [
                'role.create', 'role.delete', 'role.update', 'role.view',
                'theme.create', 'theme.delete', 'theme.update', 'theme.view',
                'user.create', 'user.delete', 'user.update', 'user.view',
                'rank.create', 'rank.delete', 'rank.update', 'rank.view',
                'department.create', 'department.delete', 'department.update', 'department.view',
                'character.create', 'character.delete', 'character.update', 'character.view',
                'story.create', 'story.delete', 'story.update',
                'post.delete', 'post.update',
            ],
            'user' => [
                'story.view',
                'post.view', 'post.create',
            ],
        ])->each(function ($permission, $role) {
            $role = Role::whereName($role)->first();

            $role->attachPermissions(
                Permission::whereIn('name', $permission)->get()->pluck('id')->all()
            );
        });
    }

    private function present(): bool
    {
        return DB::table('permission_role')->count() > 0;
    }
}
