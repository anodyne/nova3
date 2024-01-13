<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Roles\Livewire\RolesList;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('roles');

beforeEach(function () {
    $this->roles = Role::factory()
        ->count(10)
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'role.create');
    });

    test('can view the list roles page', function () {
        get(route('roles.index'))->assertSuccessful();

        livewire(RolesList::class)
            ->assertCountTableRecords(Role::count());
    });

    test('can filter roles by whether it is a default role', function () {
        $defaultRole = Role::factory()->default()->create();

        livewire(RolesList::class)
            ->filterTable('is_default', true)
            ->assertCanSeeTableRecords([$defaultRole])
            ->resetTableFilters()
            ->filterTable('is_default', false)
            ->assertCanNotSeeTableRecords([$defaultRole]);
    });

    test('can filter roles by whether it has been assigned permissions', function () {
        $roleWithPermission = Role::factory()->create();
        $roleWithPermission->givePermission(Permission::first());

        livewire(RolesList::class)
            ->filterTable('has_permissions', true)
            ->assertCanSeeTableRecords([$roleWithPermission])
            ->resetTableFilters()
            ->filterTable('has_permissions', false)
            ->assertCanNotSeeTableRecords([$roleWithPermission]);
    });

    test('can filter roles by whether it has been assigned users', function () {
        $roleWithUser = Role::factory()->create();

        User::first()->addRole($roleWithUser);

        livewire(RolesList::class)
            ->filterTable('has_users', true)
            ->assertCanSeeTableRecords([$roleWithUser])
            ->resetTableFilters()
            ->filterTable('has_users', false)
            ->assertCanNotSeeTableRecords([$roleWithUser]);
    });

    test('can search roles by name or key', function () {
        livewire(RolesList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable($this->roles->first()->display_name)
            ->assertCountTableRecords(1)
            ->resetTableFilters()
            ->searchTable($this->roles->first()->name)
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with role create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'role.create');
    });

    test('has the correct permissions', function () {
        livewire(RolesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->roles->first())
            ->assertTableActionHidden(EditAction::class, $this->roles->first())
            ->assertTableActionHidden(DeleteAction::class, $this->roles->first());
    });
});

describe('authorized user with role delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'role.delete');
    });

    test('has the correct permissions', function () {
        livewire(RolesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->roles->first())
            ->assertTableActionHidden(EditAction::class, $this->roles->first())
            ->assertTableActionVisible(DeleteAction::class, $this->roles->first());
    });
});

describe('authorized user with role update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'role.update');
    });

    test('has the correct permissions', function () {
        livewire(RolesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->roles->first())
            ->assertTableActionVisible(EditAction::class, $this->roles->first())
            ->assertTableActionHidden(DeleteAction::class, $this->roles->first());
    });
});

describe('authorized user with role view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'role.view');
    });

    test('has the correct permissions', function () {
        livewire(RolesList::class)
            ->assertTableActionVisible(ViewAction::class, $this->roles->first())
            ->assertTableActionHidden(EditAction::class, $this->roles->first())
            ->assertTableActionHidden(DeleteAction::class, $this->roles->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage roles page', function () {
        get(route('roles.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage roles page', function () {
        get(route('roles.index'))
            ->assertRedirectToRoute('login');
    });
});
