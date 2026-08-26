<?php

declare(strict_types=1);

use Nova\Roles\Models\Role;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Models\User;

use function Pest\Livewire\livewire;

uses()->group('users', 'components');

test('it can mount without a user', function () {
    livewire(ManageRoles::class)
        ->assertOk()
        ->assertSet('user', null)
        ->assertSet('assigned', []);
});

test('it can mount with a user', function () {
    $user = User::factory()->active()->create();

    livewire(ManageRoles::class, ['user' => $user])
        ->assertOk()
        ->assertSet('user', $user)
        ->assertSet('assigned', $user->roles->all());
});

test('it can add a role', function () {
    [$role1, $role2] = Role::query()->take(2)->get();

    livewire(ManageRoles::class)
        ->set('assigned', [$role1->id, $role2->id])
        ->assertSet('assigned', [$role1->id, $role2->id]);
});

test('it can remove a role', function () {
    [$role1, $role2] = Role::query()->take(2)->get();

    livewire(ManageRoles::class)
        ->set('assigned', [$role1->id, $role2->id])
        ->assertSet('assigned', [$role1->id, $role2->id])
        ->set('assigned', [$role2->id])
        ->assertSet('assigned', [$role2->id]);
});
