<?php

use Nova\Roles\Models\Role;
use Nova\Roles\Models\Ability;
use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Migrations\Migration;

class PopulateAuthorizationTables extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $this->populateAbilitiesTable();

        $this->populateRolesTable();

        $this->assignAbilitiesToRoles();

        activity()->enableLogging();
    }

    public function down()
    {
        Role::truncate();
        Ability::truncate();
    }

    protected function assignAbilitiesToRoles()
    {
        $permissions = [
            'admin' => ['role.create', 'role.delete', 'role.update', 'theme.create', 'theme.delete', 'theme.update', 'user.create', 'user.delete', 'user.update'],
            'user' => [],
        ];

        collect($permissions)->each(function ($permission, $role) {
            Bouncer::allow($role)->to(
                Ability::whereIn('name', $permission)->get()->pluck('id')->all()
            );
        });
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
