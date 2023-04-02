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
            'owner' => [
                'role.create', 'role.delete', 'role.update', 'role.view',
                'theme.create', 'theme.delete', 'theme.update', 'theme.view',
                'settings.update',
            ],
            'admin' => [
                'user.create', 'user.delete', 'user.update', 'user.view',
                'rank.create', 'rank.delete', 'rank.update', 'rank.view',
                'department.create', 'department.delete', 'department.update', 'department.view',
                'character.create', 'character.delete', 'character.update', 'character.view',
                'post-type.create', 'post-type.delete', 'post-type.update', 'post-type.view',
                'form.create', 'form.delete', 'form.update',
            ],
            'story-manager' => [
                'story.create', 'story.delete', 'story.update',
                'post.delete', 'post.update',
            ],
            'active' => [
                'form.view',
            ],
            'inactive' => [],
            'writer' => [
                'story.view',
                'post.view', 'post.create',
            ],
        ];

        collect($permissions)->each(function ($permission, $role) {
            $role = Role::whereName($role)->first();

            $role->givePermissions(
                Permission::whereIn('name', $permission)->get()->pluck('id')->all()
            );
        });
    }

    protected function populatePermissionsTable()
    {
        Permission::unguarded(function () {
            $permissions = [
                ['name' => 'role.create', 'display_name' => 'Create roles', 'description' => 'Allows a user to add new roles'],
                ['name' => 'role.delete', 'display_name' => 'Delete roles', 'description' => 'Allows a user to remove roles'],
                ['name' => 'role.update', 'display_name' => 'Update roles', 'description' => 'Allows a user to edit roles'],
                ['name' => 'role.view', 'display_name' => 'View roles', 'description' => 'Allows a user to view any roles'],

                ['name' => 'theme.create', 'display_name' => 'Create themes', 'description' => 'Allows a user to add new themes'],
                ['name' => 'theme.delete', 'display_name' => 'Delete themes', 'description' => 'Allows a user to remove themes'],
                ['name' => 'theme.update', 'display_name' => 'Update themes', 'description' => 'Allows a user to edit themes'],
                ['name' => 'theme.view', 'display_name' => 'View themes', 'description' => 'Allows a user to view any themes'],

                ['name' => 'user.create', 'display_name' => 'Create users', 'description' => 'Allows a user to add new users'],
                ['name' => 'user.delete', 'display_name' => 'Delete users', 'description' => 'Allows a user to remove users'],
                ['name' => 'user.update', 'display_name' => 'Update users', 'description' => 'Allows a user to edit users'],
                ['name' => 'user.view', 'display_name' => 'View users', 'description' => 'Allows a user to view any users'],

                ['name' => 'rank.create', 'display_name' => 'Create ranks', 'description' => 'Allows a user to add new ranks'],
                ['name' => 'rank.delete', 'display_name' => 'Delete ranks', 'description' => 'Allows a user to remove ranks'],
                ['name' => 'rank.update', 'display_name' => 'Update ranks', 'description' => 'Allows a user to edit ranks'],
                ['name' => 'rank.view', 'display_name' => 'View ranks', 'description' => 'Allows a user to view any ranks'],

                ['name' => 'department.create', 'display_name' => 'Create departments and positions', 'description' => 'Allows a user to add new departments and positions'],
                ['name' => 'department.delete', 'display_name' => 'Delete departments and positions', 'description' => 'Allows a user to remove departments and positions'],
                ['name' => 'department.update', 'display_name' => 'Update departments and positions', 'description' => 'Allows a user to edit departments and positions'],
                ['name' => 'department.view', 'display_name' => 'View departments and positions', 'description' => 'Allows a user to view any departments and positions'],

                ['name' => 'character.create', 'display_name' => 'Create characters', 'description' => 'Allows a user to add new characters'],
                ['name' => 'character.delete', 'display_name' => 'Delete characters', 'description' => 'Allows a user to remove characters'],
                ['name' => 'character.update', 'display_name' => 'Update characters', 'description' => 'Allows a user to edit characters'],
                ['name' => 'character.view', 'display_name' => 'View characters', 'description' => 'Allows a user to view any characters'],

                ['name' => 'story.create', 'display_name' => 'Create stories', 'description' => 'Allows a user to add new stories'],
                ['name' => 'story.delete', 'display_name' => 'Delete stories', 'description' => 'Allows a user to remove stories'],
                ['name' => 'story.update', 'display_name' => 'Update stories', 'description' => 'Allows a user to edit stories'],
                ['name' => 'story.view', 'display_name' => 'View stories', 'description' => 'Allows a user to view any stories'],

                ['name' => 'post-type.create', 'display_name' => 'Create post types', 'description' => 'Allows a user to add new post types'],
                ['name' => 'post-type.delete', 'display_name' => 'Delete post types', 'description' => 'Allows a user to remove post types'],
                ['name' => 'post-type.update', 'display_name' => 'Update post types', 'description' => 'Allows a user to edit post types'],
                ['name' => 'post-type.view', 'display_name' => 'View post types', 'description' => 'Allows a user to view any post types'],

                ['name' => 'post.create', 'display_name' => 'Create posts', 'description' => 'Allows a user to add new posts'],
                ['name' => 'post.delete', 'display_name' => 'Delete posts', 'description' => 'Allows a user to remove posts'],
                ['name' => 'post.update', 'display_name' => 'Update posts', 'description' => 'Allows a user to edit posts'],
                ['name' => 'post.view', 'display_name' => 'View posts', 'description' => 'Allows a user to view any posts'],

                ['name' => 'settings.update', 'display_name' => 'Update settings', 'description' => 'Allows a user to edit settings'],

                ['name' => 'form.create', 'display_name' => 'Create forms', 'description' => 'Allows a user to add new forms'],
                ['name' => 'form.delete', 'display_name' => 'Delete forms', 'description' => 'Allows a user to remove forms'],
                ['name' => 'form.update', 'display_name' => 'Update forms', 'description' => 'Allows a user to edit forms'],
                ['name' => 'form.view', 'display_name' => 'View forms', 'description' => 'Allows a user to view any forms'],
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
                ['name' => 'owner', 'display_name' => 'Site Owner', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'locked' => true, 'sort' => 0],
                ['name' => 'admin', 'display_name' => 'Site Admin', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'locked' => true, 'sort' => 1],
                ['name' => 'active', 'display_name' => 'Active User', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'default' => true, 'sort' => 2],
                ['name' => 'story-manager', 'display_name' => 'Story Manager', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'default' => false, 'sort' => 3],
                ['name' => 'writer', 'display_name' => 'Writer', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'default' => true, 'sort' => 4],
                ['name' => 'inactive', 'display_name' => 'Inactive User', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'default' => false, 'sort' => 5],
            ];

            collect($roles)->each(function ($role) {
                Role::firstOrCreate($role);
            });
        });
    }
}
