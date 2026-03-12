<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $this->populatePermissionsTable();
            $this->populateRolesTable();
            $this->assignPermissionsToRolesBulk();
        });
    }

    public function down(): void
    {
        DB::table(config('laratrust.tables.permission_role'))->truncate();
        DB::table(config('laratrust.tables.permissions'))->truncate();
        DB::table(config('laratrust.tables.roles'))->truncate();
    }

    protected function assignPermissionsToRolesBulk(): void
    {
        $map = [
            'owner' => [
                'role.create', 'role.delete', 'role.update', 'role.view',
                'theme.create', 'theme.delete', 'theme.update', 'theme.view',
                'addon.create', 'addon.delete', 'addon.update', 'addon.view',
                'settings.update', 'site.update', 'system.overview',
            ],
            'admin' => [
                'user.create', 'user.delete', 'user.update', 'user.view', 'user.impersonate',
                'rank.create', 'rank.delete', 'rank.update', 'rank.view',
                'department.create', 'department.delete', 'department.update', 'department.view',
                'character.create', 'character.delete', 'character.update', 'character.view', 'character.activate', 'character.deactivate', 'character.restore',
                'post-type.create', 'post-type.delete', 'post-type.update', 'post-type.view', 'post-type.restore',
                'form.create', 'form.delete', 'form.update',
                'form-submission.view-all', 'form-submission.delete',
                'page.create', 'page.delete', 'page.update', 'page.view',
                'application.approve',
                'system.activity', 'system.error-logs',
                'menu.create', 'menu.delete', 'menu.update', 'menu.view',
                'announcement.create', 'announcement.delete', 'announcement.update', 'announcement.approve',
                'ban.create', 'ban.delete', 'ban.update', 'ban.view',
                'report.view',
            ],
            'story-manager' => [
                'story.create', 'story.delete', 'story.update',
                'post.delete', 'post.update', 'post.approve',
            ],
            'active' => ['announcement.view'],
            'writer' => ['story.view', 'post.view', 'post.create'],
            'create-primary-characters' => ['character.create-primary'],
            'create-secondary-characters' => ['character.create-secondary'],
            'create-support-characters' => ['character.create-support'],
            'update-support-characters' => ['character.update-support'],
            'webmaster' => ['site.contact'],
        ];

        $rolesTable = config('laratrust.tables.roles');
        $permsTable = config('laratrust.tables.permissions');
        $pivotTable = config('laratrust.tables.permission_role');

        $roleNames = array_keys($map);
        $permissionNames = array_values(array_unique(array_merge(...array_values($map))));

        $roleIds = DB::table($rolesTable)->whereIn('name', $roleNames)->pluck('id', 'name')->all();
        $permissionIds = DB::table($permsTable)->whereIn('name', $permissionNames)->pluck('id', 'name')->all();

        $rows = [];
        foreach ($map as $roleName => $names) {
            $roleId = $roleIds[$roleName] ?? null;
            if (! $roleId) {
                continue;
            }

            foreach ($names as $permissionName) {
                $permissionId = $permissionIds[$permissionName] ?? null;
                if (! $permissionId) {
                    continue;
                }

                $rows[] = [
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                ];
            }
        }

        if (! $rows) {
            return;
        }

        DB::table($pivotTable)->insertOrIgnore($rows);
    }

    protected function populatePermissionsTable(): void
    {
        $table = config('laratrust.tables.permissions');
        $now = now();

        $permissions = [
            ['name' => 'role.create', 'display_name' => 'Create roles', 'description' => 'Allows a user to add new roles'],
            ['name' => 'role.delete', 'display_name' => 'Delete roles', 'description' => 'Allows a user to remove roles'],
            ['name' => 'role.update', 'display_name' => 'Update roles', 'description' => 'Allows a user to edit roles'],
            ['name' => 'role.view', 'display_name' => 'View roles', 'description' => 'Allows a user to view any roles'],

            ['name' => 'theme.create', 'display_name' => 'Create themes', 'description' => 'Allows a user to add new themes'],
            ['name' => 'theme.delete', 'display_name' => 'Delete themes', 'description' => 'Allows a user to remove themes'],
            ['name' => 'theme.update', 'display_name' => 'Update themes', 'description' => 'Allows a user to edit themes'],
            ['name' => 'theme.view', 'display_name' => 'View themes', 'description' => 'Allows a user to view any themes'],

            ['name' => 'addon.create', 'display_name' => 'Create add-ons', 'description' => 'Allows a user to add new add-ons'],
            ['name' => 'addon.delete', 'display_name' => 'Delete add-ons', 'description' => 'Allows a user to remove add-ons'],
            ['name' => 'addon.update', 'display_name' => 'Update add-ons', 'description' => 'Allows a user to edit add-ons'],
            ['name' => 'addon.view', 'display_name' => 'View add-ons', 'description' => 'Allows a user to view any add-ons'],

            ['name' => 'user.create', 'display_name' => 'Create users', 'description' => 'Allows a user to add new users'],
            ['name' => 'user.delete', 'display_name' => 'Delete users', 'description' => 'Allows a user to remove users'],
            ['name' => 'user.update', 'display_name' => 'Update users', 'description' => 'Allows a user to edit users'],
            ['name' => 'user.view', 'display_name' => 'View users', 'description' => 'Allows a user to view any users'],
            ['name' => 'user.impersonate', 'display_name' => 'Impersonate users', 'description' => 'Allows a user to impersonate other users for support purposes'],

            ['name' => 'rank.create', 'display_name' => 'Create ranks', 'description' => 'Allows a user to add new ranks'],
            ['name' => 'rank.delete', 'display_name' => 'Delete ranks', 'description' => 'Allows a user to remove ranks'],
            ['name' => 'rank.update', 'display_name' => 'Update ranks', 'description' => 'Allows a user to edit ranks'],
            ['name' => 'rank.view', 'display_name' => 'View ranks', 'description' => 'Allows a user to view any ranks'],

            ['name' => 'department.create', 'display_name' => 'Create departments and positions', 'description' => 'Allows a user to add new departments and positions'],
            ['name' => 'department.delete', 'display_name' => 'Delete departments and positions', 'description' => 'Allows a user to remove departments and positions'],
            ['name' => 'department.update', 'display_name' => 'Update departments and positions', 'description' => 'Allows a user to edit departments and positions'],
            ['name' => 'department.view', 'display_name' => 'View departments and positions', 'description' => 'Allows a user to view any departments and positions'],

            ['name' => 'character.create', 'display_name' => 'Create characters', 'description' => 'Allows a user to add new characters'],
            ['name' => 'character.create-primary', 'display_name' => 'Create primary characters', 'description' => 'Allows a user to add new primary characters for themselves'],
            ['name' => 'character.create-secondary', 'display_name' => 'Create secondary characters', 'description' => 'Allows a user to add new secondary characters for themselves'],
            ['name' => 'character.create-support', 'display_name' => 'Create support characters', 'description' => 'Allows a user to add new support characters (not assigned to any user)'],
            ['name' => 'character.delete', 'display_name' => 'Delete characters', 'description' => 'Allows a user to remove characters'],
            ['name' => 'character.update', 'display_name' => 'Update all characters', 'description' => 'Allows a user to edit all characters'],
            ['name' => 'character.update-support', 'display_name' => 'Update support characters', 'description' => 'Allows a user to edit any support characters'],
            ['name' => 'character.view', 'display_name' => 'View characters', 'description' => 'Allows a user to view any characters'],
            ['name' => 'character.activate', 'display_name' => 'Activate characters', 'description' => 'Allows a user to activate any inactive characters'],
            ['name' => 'character.deactivate', 'display_name' => 'Deactivate characters', 'description' => 'Allows a user to deactivate any active characters'],
            ['name' => 'character.restore', 'display_name' => 'Restore characters', 'description' => 'Allows a user to restore any deleted characters'],

            ['name' => 'story.create', 'display_name' => 'Create stories', 'description' => 'Allows a user to add new stories'],
            ['name' => 'story.delete', 'display_name' => 'Delete stories', 'description' => 'Allows a user to remove stories'],
            ['name' => 'story.update', 'display_name' => 'Update stories', 'description' => 'Allows a user to edit stories'],
            ['name' => 'story.view', 'display_name' => 'View stories', 'description' => 'Allows a user to view any stories'],

            ['name' => 'post-type.create', 'display_name' => 'Create post types', 'description' => 'Allows a user to add new post types'],
            ['name' => 'post-type.delete', 'display_name' => 'Delete post types', 'description' => 'Allows a user to remove post types'],
            ['name' => 'post-type.update', 'display_name' => 'Update post types', 'description' => 'Allows a user to edit post types'],
            ['name' => 'post-type.view', 'display_name' => 'View post types', 'description' => 'Allows a user to view any post types'],
            ['name' => 'post-type.restore', 'display_name' => 'Restore post types', 'description' => 'Allows a user to restory any deleted post types'],

            ['name' => 'post.create', 'display_name' => 'Create posts', 'description' => 'Allows a user to add new posts'],
            ['name' => 'post.delete', 'display_name' => 'Delete posts', 'description' => 'Allows a user to remove posts'],
            ['name' => 'post.update', 'display_name' => 'Update posts', 'description' => 'Allows a user to edit posts'],
            ['name' => 'post.view', 'display_name' => 'View posts', 'description' => 'Allows a user to view any posts'],
            ['name' => 'post.approve', 'display_name' => 'Approve posts', 'description' => 'Allows a user to approve any pending posts'],

            ['name' => 'settings.update', 'display_name' => 'Update settings', 'description' => 'Allows a user to edit settings'],

            ['name' => 'form.create', 'display_name' => 'Create forms', 'description' => 'Allows a user to add new forms'],
            ['name' => 'form.delete', 'display_name' => 'Delete forms', 'description' => 'Allows a user to remove forms'],
            ['name' => 'form.update', 'display_name' => 'Update forms', 'description' => 'Allows a user to edit forms'],
            ['name' => 'form.view', 'display_name' => 'View forms', 'description' => 'Allows a user to view any forms'],

            ['name' => 'form-submission.view-all', 'display_name' => 'View all form submissions', 'description' => 'Allows a user to view any form submission'],
            ['name' => 'form-submission.delete', 'display_name' => 'Delete form submissions', 'description' => 'Allows a user to remove any form submission'],

            ['name' => 'page.create', 'display_name' => 'Create pages', 'description' => 'Allows a user to add new pages'],
            ['name' => 'page.delete', 'display_name' => 'Delete pages', 'description' => 'Allows a user to remove pages'],
            ['name' => 'page.update', 'display_name' => 'Update pages', 'description' => 'Allows a user to edit pages'],
            ['name' => 'page.view', 'display_name' => 'View pages', 'description' => 'Allows a user to view any pages'],

            ['name' => 'application.approve', 'display_name' => 'Approve applications', 'description' => 'Allows a user to approve or deny applications'],

            ['name' => 'system.activity', 'display_name' => 'View activity log', 'description' => 'Allows a user to view the activity log for the site'],
            ['name' => 'system.error-logs', 'display_name' => 'View error logs', 'description' => 'Allows a user to view the error logs for the site'],
            ['name' => 'system.overview', 'display_name' => 'View system overview dashboard', 'description' => 'Allows a user to view the system overview dashboard for the site'],

            ['name' => 'menu.create', 'display_name' => 'Create menus', 'description' => 'Allows a user to add new menus'],
            ['name' => 'menu.delete', 'display_name' => 'Delete menus', 'description' => 'Allows a user to remove menus'],
            ['name' => 'menu.update', 'display_name' => 'Update menus', 'description' => 'Allows a user to edit menus'],
            ['name' => 'menu.view', 'display_name' => 'View menus', 'description' => 'Allows a user to view any menus'],

            ['name' => 'announcement.create', 'display_name' => 'Create announcements', 'description' => 'Allows a user to add new announcements'],
            ['name' => 'announcement.delete', 'display_name' => 'Delete announcements', 'description' => 'Allows a user to remove announcements'],
            ['name' => 'announcement.update', 'display_name' => 'Update announcements', 'description' => 'Allows a user to edit announcements'],
            ['name' => 'announcement.view', 'display_name' => 'View announcements', 'description' => 'Allows a user to view any announcements'],
            ['name' => 'announcement.approve', 'display_name' => 'Approve announcements', 'description' => 'Allows a user to approve any pending announcements'],

            ['name' => 'site.contact', 'display_name' => 'Site contact', 'description' => 'Allows a user to receive site contact messages'],
            ['name' => 'site.update', 'display_name' => 'Update site', 'description' => 'Allows a user to run the update scripts for the site'],

            ['name' => 'report.view', 'display_name' => 'View reports', 'description' => 'Allows a user to view any reports'],

            ['name' => 'ban.create', 'display_name' => 'Create bans', 'description' => 'Allows a user to add new bans'],
            ['name' => 'ban.delete', 'display_name' => 'Delete bans', 'description' => 'Allows a user to remove bans'],
            ['name' => 'ban.update', 'display_name' => 'Update bans', 'description' => 'Allows a user to edit bans'],
            ['name' => 'ban.view', 'display_name' => 'View bans', 'description' => 'Allows a user to view any bans'],
        ];

        DB::table($table)->upsert(
            array_map(fn ($permission) => $permission + ['created_at' => $now, 'updated_at' => $now], $permissions),
            ['name'],
            ['display_name', 'description', 'updated_at']
        );
    }

    protected function populateRolesTable(): void
    {
        $table = config('laratrust.tables.roles');
        $now = now();

        $roles = [
            [
                'name' => 'owner',
                'display_name' => 'Site Owner',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'is_locked' => true,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Site Admin',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'is_locked' => true,
            ],
            [
                'name' => 'active',
                'display_name' => 'Active User',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'is_default' => true,
            ],
            [
                'name' => 'story-manager',
                'display_name' => 'Story Manager',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'name' => 'writer',
                'display_name' => 'Writer',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'is_default' => true,
            ],
            [
                'name' => 'create-primary-characters',
                'display_name' => 'Create Primary Characters',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'name' => 'create-secondary-characters',
                'display_name' => 'Create Secondary Characters',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'name' => 'create-support-characters',
                'display_name' => 'Create Support Characters',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'name' => 'update-support-characters',
                'display_name' => 'Update Support Characters',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'name' => 'webmaster',
                'display_name' => 'Webmaster',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
        ];

        $defaults = [
            'is_default' => false,
            'is_locked' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $data = [];

        $order = 1;
        foreach ($roles as $role) {
            $data[] = $role + $defaults + [
                'order_column' => $order++,
            ];
        }

        DB::table($table)->upsert(
            $data,
            ['name'],
            ['display_name', 'description', 'is_default', 'is_locked', 'order_column', 'updated_at']
        );
    }
};
