<?php

use Nova\Roles\Models\Role;
use Nova\Roles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
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
        ];

        collect($permissions)->each(function ($permission) {
            Permission::firstOrCreate($permission);
        });
    }

    protected function populateRolesTable()
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'System Admin', 'locked' => true],
            ['name' => 'user', 'display_name' => 'Basic User'],
        ];

        Model::unguard();

        collect($roles)->each(function ($role) {
            Role::firstOrCreate($role);
        });

        Model::reguard();
    }
}
