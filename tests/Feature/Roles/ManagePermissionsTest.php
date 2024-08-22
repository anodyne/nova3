<?php

declare(strict_types=1);

use Nova\Roles\Livewire\PermissionsList;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('roles');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'role.create');
    });

    test('can view the list permissions page', function () {
        get(route('admin.permissions.index'))->assertSuccessful();

        livewire(PermissionsList::class)
            ->assertCountTableRecords(Permission::count());
    });

    test('can filter permissions by assigned role', function () {
        $roleWithPermission = Role::factory()->create();
        $roleWithPermission->givePermission($permission = Permission::first());

        livewire(PermissionsList::class)
            ->filterTable('roles', $roleWithPermission->id)
            ->assertCanSeeTableRecords([$permission]);
    });

    test('can search permissions by name or key', function () {
        $permission = Permission::first();

        livewire(PermissionsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable($permission->display_name)
            ->assertCountTableRecords(1)
            ->resetTableFilters()
            ->searchTable($permission->name)
            ->assertCountTableRecords(1);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage permissions page', function () {
        get(route('admin.permissions.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage permissions page', function () {
        get(route('admin.permissions.index'))
            ->assertRedirectToRoute('login');
    });
});
