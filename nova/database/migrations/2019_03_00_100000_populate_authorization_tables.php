<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

class PopulateAuthorizationTables extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $this->populatePermissionsTable();

        $this->populateRolesTable();

        $this->assignPermissionsToRoles();

        activity()->enableLogging();
    }

    public function down()
    {
        Role::truncate();
        Permission::truncate();
    }

    protected function assignPermissionsToRoles()
    {
        $permissions = [
            'admin' => [
                'role.create', 'role.delete', 'role.update', 'role.view',
                'theme.create', 'theme.delete', 'theme.update', 'theme.view',
                'user.create', 'user.delete', 'user.update', 'user.view',
                'rank.create', 'rank.delete', 'rank.update', 'rank.view',
                'department.create', 'department.delete', 'department.update', 'department.view',
                'character.create', 'character.delete', 'character.update', 'character.view',
                'story.create', 'story.delete', 'story.update',
                'post.delete', 'post.update',
                'settings.update',
            ],
            'user' => [
                'story.view',
                'post.view', 'post.create',
            ],
        ];

        collect($permissions)->each(function ($permission, $role) {
            $role = Role::whereName($role)->first();

            $role->attachPermissions(
                Permission::whereIn('name', $permission)->get()->pluck('id')->all()
            );
        });
    }

    protected function populatePermissionsTable()
    {
        Permission::unguarded(function () {
            $permissions = [
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

                ['name' => 'settings.update', 'display_name' => 'Update settings'],
            ];

            collect($permissions)->each(function ($permission) {
                Permission::firstOrCreate($permission);
            });
        });
    }

    protected function populateRolesTable()
    {
        Role::unguarded(function () {
            $roles = [
                ['name' => 'admin', 'display_name' => 'System Admin', 'locked' => true, 'sort' => 0],
                ['name' => 'user', 'display_name' => 'Active User', 'default' => true, 'sort' => 1],
            ];

            collect($roles)->each(function ($role) {
                Role::firstOrCreate($role);
            });
        });
    }
}
