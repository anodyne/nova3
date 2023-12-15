<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Nova\Roles\Models\Role;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Models\User;

use function Pest\Livewire\livewire;

uses()->group('users');
uses()->group('components');

test('it can mount without a user', function () {
    livewire(ManageRoles::class)
        ->assertOk()
        ->assertSet('user', null)
        ->assertSet('assigned', Collection::make());
});

test('it can mount with a user', function () {
    $user = User::factory()->active()->create();

    livewire(ManageRoles::class, ['user' => $user])
        ->assertOk()
        ->assertSet('user', $user)
        ->assertSet('assigned', $user->roles);
});

test('it can search roles', function () {
    livewire(ManageRoles::class)
        ->set('search', 'owner')
        ->assertSet('searchResults', $roles = Role::searchFor('owner')->get())
        ->assertCount('searchResults', $roles->count());
});

test('it can list all roles in the search results', function () {
    livewire(ManageRoles::class)
        ->set('search', '*')
        ->assertSet('searchResults', $roles = Role::get())
        ->assertCount('searchResults', $roles->count());
});

test('it can add a role', function () {
    $role1 = Role::find(1);
    $role2 = Role::find(2);

    livewire(ManageRoles::class)
        ->call('add', $role1->id)
        ->call('add', $role2->id)
        ->assertSet('assignedRoles', '1,2');
});

test('it can remove a role', function () {
    $role1 = Role::find(1);
    $role2 = Role::find(2);

    livewire(ManageRoles::class)
        ->call('add', $role1->id)
        ->call('add', $role2->id)
        ->assertSet('assignedRoles', '1,2')
        ->call('remove', $role1->id)
        ->assertSet('assignedRoles', '2');
});
