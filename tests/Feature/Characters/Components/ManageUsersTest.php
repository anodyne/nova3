<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Nova\Characters\Livewire\ManageUsers;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

use function Pest\Livewire\livewire;

uses()->group('characters');
uses()->group('components');

it('can mount without a character', function () {
    livewire(ManageUsers::class)
        ->assertOk()
        ->assertSet('character', null)
        ->assertSet('assigned', Collection::make())
        ->assertSet('primary', Collection::make());
});

it('can mount with a character', function () {
    $character = Character::factory()
        ->active()
        ->hasAttached(User::factory()->active())
        ->create();

    livewire(ManageUsers::class, ['character' => $character])
        ->assertOk()
        ->assertSet('character', $character)
        ->assertSet('assigned', $character->users)
        ->assertSet('primary', Collection::make());
});

it('can assign a user', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    livewire(ManageUsers::class)
        ->set('selected', (string) $user1->id)
        ->set('selected', (string) $user2->id)
        ->assertSet('assignedUsers', "{$user1->id},{$user2->id}");
});

it('can unassign a user', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    livewire(ManageUsers::class)
        ->set('selected', (string) $user1->id)
        ->set('selected', (string) $user2->id)
        ->call('remove', $user1->id)
        ->assertSet('assignedUsers', "{$user2->id}");
});

it('can set a primary user for the character', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    livewire(ManageUsers::class)
        ->set('selected', (string) $user1->id)
        ->set('selected', (string) $user2->id)
        ->call('setPrimaryCharacterForUser', $user1->id)
        ->call('setPrimaryCharacterForUser', $user2->id)
        ->assertSet('primaryUsers', "{$user1->id},{$user2->id}");
});
