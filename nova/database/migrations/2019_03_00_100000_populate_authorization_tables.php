<?php

use Nova\Roles\Models\Role;
use Nova\Roles\Models\Permission;
use Illuminate\Database\Migrations\Migration;

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
            ],
            'user' => [],
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
                ['name' => 'role.create', 'display_name' => 'Create role'],
                ['name' => 'role.delete', 'display_name' => 'Delete role'],
                ['name' => 'role.update', 'display_name' => 'Update role'],
                ['name' => 'role.view', 'display_name' => 'View role'],

                ['name' => 'theme.create', 'display_name' => 'Create theme'],
                ['name' => 'theme.delete', 'display_name' => 'Delete theme'],
                ['name' => 'theme.update', 'display_name' => 'Update theme'],
                ['name' => 'theme.view', 'display_name' => 'View theme'],

                ['name' => 'user.create', 'display_name' => 'Create user'],
                ['name' => 'user.delete', 'display_name' => 'Delete user'],
                ['name' => 'user.update', 'display_name' => 'Update user'],
                ['name' => 'user.view', 'display_name' => 'View user'],

                ['name' => 'rank.create', 'display_name' => 'Create rank'],
                ['name' => 'rank.delete', 'display_name' => 'Delete rank'],
                ['name' => 'rank.update', 'display_name' => 'Update rank'],
                ['name' => 'rank.view', 'display_name' => 'View rank'],

                ['name' => 'department.create', 'display_name' => 'Create departments and positions'],
                ['name' => 'department.delete', 'display_name' => 'Delete departments and positions'],
                ['name' => 'department.update', 'display_name' => 'Update departments and positions'],
                ['name' => 'department.view', 'display_name' => 'View departments and positions'],
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
                ['name' => 'admin', 'display_name' => 'System Admin', 'locked' => true],
                ['name' => 'user', 'display_name' => 'Active User', 'default' => true],
            ];

            collect($roles)->each(function ($role) {
                Role::firstOrCreate($role);
            });
        });
    }
}
