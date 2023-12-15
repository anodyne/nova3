<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Nova\Roles\Livewire\ManageUsers;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

use function Pest\Livewire\livewire;

uses()->group('roles');
uses()->group('components');

test('it can mount without a role', function () {
    livewire(ManageUsers::class)
        ->assertOk()
        ->assertSet('role', null)
        ->assertSet('assigned', Collection::make());
});

test('it can mount with a role', function () {
    $role = Role::first();

    $user = User::factory()->create();
    $user->addRole($role);

    $role->refresh();

    livewire(ManageUsers::class, ['role' => $role])
        ->assertOk()
        ->assertSet('role', $role)
        ->assertNotSet('assigned', Collection::make(), strict: true);
});

test('it can search users', function () {
    User::factory()->create(['name' => 'John']);
    User::factory()->count(4)->create();

    livewire(ManageUsers::class)
        ->set('search', 'John')
        ->assertSet('searchResults', $users = User::searchFor('John')->get())
        ->assertCount('searchResults', $users->count());
});

test('it can list all users in the search results', function () {
    livewire(ManageUsers::class)
        ->set('search', '*')
        ->assertSet('searchResults', $users = User::get())
        ->assertCount('searchResults', $users->count());
});

test('it can assign a user', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    livewire(ManageUsers::class)
        ->call('add', $user1->id)
        ->call('add', $user2->id)
        ->assertSet('assignedUsers', "{$user1->id},{$user2->id}");
});

test('it can unassign a user', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    livewire(ManageUsers::class)
        ->call('add', $user1->id)
        ->call('add', $user2->id)
        ->assertSet('assignedUsers', "{$user1->id},{$user2->id}")
        ->call('remove', $user1->id)
        ->assertSet('assignedUsers', "{$user2->id}");
});
