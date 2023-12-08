<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

use function Pest\Livewire\livewire;

uses()->group('roles');
uses()->group('components');

test('it can mount without a role', function () {
    livewire(ManagePermissions::class)
        ->assertOk()
        ->assertSet('role', null)
        ->assertSet('assigned', Collection::make());
});

test('it can mount with a role', function () {
    $role = Role::first();

    livewire(ManagePermissions::class, ['role' => $role])
        ->assertOk()
        ->assertSet('role', $role)
        ->assertSet('assigned', $role->permissions);
});

test('it can search permissions', function () {
    livewire(ManagePermissions::class)
        ->set('search', 'create')
        ->assertSet('filteredPermissions', $permissions = Permission::searchFor('create')->get())
        ->assertCount('filteredPermissions', $permissions->count());
});

test('it can list all permissions in the search results', function () {
    livewire(ManagePermissions::class)
        ->set('search', '*')
        ->assertSet('filteredPermissions', $permissions = Permission::get())
        ->assertCount('filteredPermissions', $permissions->count());
});

test('it can add a permission', function () {
    $permission1 = Permission::find(1);
    $permission2 = Permission::find(2);

    livewire(ManagePermissions::class)
        ->call('addPermission', $permission1->id)
        ->call('addPermission', $permission2->id)
        ->assertSet('assignedPermissions', '1,2');
});

test('it can remove a permission', function () {
    $permission1 = Permission::find(1);
    $permission2 = Permission::find(2);

    livewire(ManagePermissions::class)
        ->call('addPermission', $permission1->id)
        ->call('addPermission', $permission2->id)
        ->assertSet('assignedPermissions', '1,2')
        ->call('removePermission', $permission1->id)
        ->assertSet('assignedPermissions', '2');
});
