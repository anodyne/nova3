<?php

use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;
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
        ];

        collect($abilities)->each(function ($ability) {
            Bouncer::ability()->firstOrCreate($ability);
        });
    }

    protected function populateRolesTable()
    {
        $roles = [
            ['name' => 'admin', 'title' => 'System Admin'],
            ['name' => 'user', 'title' => 'Basic User'],
        ];

        collect($roles)->each(function ($role) {
            Bouncer::role()->firstOrCreate($role);
        });
    }
}
