<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Nova\Characters\Models\Character;
use Nova\Users\Livewire\ManageCharacters;
use Nova\Users\Models\User;

use function Pest\Livewire\livewire;

uses()->group('users');
uses()->group('components');

test('it can mount without a user', function () {
    livewire(ManageCharacters::class)
        ->assertOk()
        ->assertSet('user', null)
        ->assertSet('assigned', Collection::make());
});

test('it can mount with a user', function () {
    $user = User::factory()->active()->create();

    livewire(ManageCharacters::class, ['user' => $user])
        ->assertOk()
        ->assertSet('user', $user)
        ->assertSet('assigned', $user->roles);
});

test('it can search characters', function () {
    signIn();

    Character::factory()->active()->create(['name' => 'John Doe']);

    livewire(ManageCharacters::class)
        ->set('search', 'john')
        ->assertSet('searchResults', $characters = Character::searchFor('john')->get())
        ->assertCount('searchResults', $characters->count());
});

test('it can list all characters in the search results', function () {
    signIn();

    Character::factory()->active()->create(['name' => 'John Doe']);

    livewire(ManageCharacters::class)
        ->set('search', '*')
        ->assertSet('searchResults', $characters = Character::get())
        ->assertCount('searchResults', $characters->count());
});

test('it can add a character', function () {
    $character1 = Character::factory()->active()->create();
    $character2 = Character::factory()->active()->create();

    livewire(ManageCharacters::class)
        ->call('add', $character1->id)
        ->call('add', $character2->id)
        ->assertSet('assignedCharacters', "{$character1->id},{$character2->id}");
});

test('it can remove a character', function () {
    $character1 = Character::factory()->active()->create();
    $character2 = Character::factory()->active()->create();

    livewire(ManageCharacters::class)
        ->call('add', $character1->id)
        ->call('add', $character2->id)
        ->assertSet('assignedCharacters', "{$character1->id},{$character2->id}")
        ->call('remove', $character1->id)
        ->assertSet('assignedCharacters', $character2->id);
});

test('it can set a character as the primary character', function () {
    $character1 = Character::factory()->active()->create();
    $character2 = Character::factory()->active()->create();

    livewire(ManageCharacters::class)
        ->call('add', $character1->id)
        ->call('add', $character2->id)
        ->call('setAsPrimaryCharacter', $character2->id)
        ->assertSet('primaryCharacter', $character2->id);
});

test('it can change the primary character after it has been set', function () {
    $character1 = Character::factory()->active()->create();
    $character2 = Character::factory()->active()->create();

    livewire(ManageCharacters::class)
        ->call('add', $character1->id)
        ->call('add', $character2->id)
        ->call('setAsPrimaryCharacter', $character2->id)
        ->assertSet('primaryCharacter', $character2->id)
        ->call('setAsPrimaryCharacter', $character1->id)
        ->assertSet('primaryCharacter', $character1->id);
});
