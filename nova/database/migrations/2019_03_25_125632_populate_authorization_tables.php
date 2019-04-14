<?php

use Nova\Roles\Models\Role;
use Nova\Roles\Models\Ability;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;

class PopulateAuthorizationTables extends Migration
{
    public function up()
    {
        $this->populateAbilitiesTable();

        $this->populateRolesTable();

        $this->assignAbilitiesToRoles();
    }

    public function down()
    {
        Role::truncate();
        Ability::truncate();
    }

    protected function assignAbilitiesToRoles()
    {
        Bouncer::allow('admin')->everything();
    }

    protected function populateAbilitiesTable()
    {
        $abilities = [
            ['name' => 'role.create', 'title' => 'Create role'],
            ['name' => 'role.delete', 'title' => 'Delete role'],
            ['name' => 'role.update', 'title' => 'Update role'],

            ['name' => 'theme.create', 'title' => 'Create theme'],
            ['name' => 'theme.delete', 'title' => 'Delete theme'],
            ['name' => 'theme.update', 'title' => 'Update theme'],

            ['name' => 'user.create', 'title' => 'Create user'],
            ['name' => 'user.delete', 'title' => 'Delete user'],
            ['name' => 'user.update', 'title' => 'Update user'],
        ];

        collect($abilities)->each(function ($ability) {
            Bouncer::ability()->firstOrCreate($ability);
        });
    }

    protected function populateRolesTable()
    {
        $roles = [
            ['name' => 'admin', 'title' => 'System Admin', 'locked' => true],
            ['name' => 'user', 'title' => 'Basic User'],
        ];

        Model::unguard();

        collect($roles)->each(function ($role) {
            Bouncer::role()->firstOrCreate($role);
        });

        Model::reguard();
    }
}
