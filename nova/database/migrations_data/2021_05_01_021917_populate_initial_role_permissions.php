<?php

use Illuminate\Database\Migrations\Migration;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

class PopulateInitialRolePermissions extends Migration
{
    public function up(): void
    {
        $this->run('attachPermissions');
    }

    public function down(): void
    {
        $this->run('detachPermissions');
    }

    public function run($method): void
    {
        collect([
            $this->adminPermissions(),
            $this->userPermissions(),
        ])->each(function ($permission, $role) use ($method) {
            $role = Role::whereName($role)->first();

            $role->$method(
                Permission::whereIn('name', $permission)->get()->pluck('id')->all()
            );
        });
    }

    public function adminPermissions(): array
    {
        return ['admin' => [
            'role.create', 'role.delete', 'role.update', 'role.view',
            'theme.create', 'theme.delete', 'theme.update', 'theme.view',
            'user.create', 'user.delete', 'user.update', 'user.view',
            'rank.create', 'rank.delete', 'rank.update', 'rank.view',
            'department.create', 'department.delete', 'department.update', 'department.view',
            'character.create', 'character.delete', 'character.update', 'character.view',
            'story.create', 'story.delete', 'story.update',
            'post.delete', 'post.update',
        ]];
    }

    public function userPermissions(): array
    {
        return ['user' => [
            'story.view',
            'post.view', 'post.create',
        ]];
    }
}
