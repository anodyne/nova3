<?php

declare(strict_types=1);

use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

use function Pest\Livewire\livewire;

uses()->group('roles', 'components');

test('it can mount without a role', function () {
    livewire(ManagePermissions::class)
        ->assertOk()
        ->assertSet('role', null)
        ->assertSet('assigned', []);
});

test('it can mount with a role', function () {
    $role = Role::first();

    livewire(ManagePermissions::class, ['role' => $role])
        ->assertOk()
        ->assertSet('role', $role)
        ->assertSet('assigned', $role->permissions->pluck('id')->all());
});

test('it can add a permission', function () {
    $permission1 = Permission::find(1);
    $permission2 = Permission::find(2);

    livewire(ManagePermissions::class)
        ->set('assigned', [$permission1->id, $permission2->id])
        ->assertSet('assigned', [$permission1->id, $permission2->id]);
});

test('it can remove a permission', function () {
    $permission1 = Permission::find(1);
    $permission2 = Permission::find(2);

    livewire(ManagePermissions::class)
        ->set('assigned', [$permission1->id, $permission2->id])
        ->assertSet('assigned', [$permission1->id, $permission2->id])
        ->set('assigned', [$permission2->id])
        ->assertSet('assigned', [$permission2->id]);
});
