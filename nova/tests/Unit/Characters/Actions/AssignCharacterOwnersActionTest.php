<?php

declare(strict_types=1);

use Nova\Characters\Actions\AssignCharacterOwners;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->active()->create();
});

it('assigns one user to a character without any users', function () {
    $first = User::factory()->active()->create();

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(1);
    expect($character->activePrimaryUsers)->toHaveCount(0);
    expect($character->users->first()->is($first))->toBeTrue();
});

it('assigns one user to a character without any users and sets the character as the primary character for that user', function () {
    $first = User::factory()->active()->create();

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id],
        'primaryUsers' => [$first->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(1);
    expect($character->activePrimaryUsers)->toHaveCount(1);
    expect($character->users->first()->is($first))->toBeTrue();
    expect($character->activePrimaryUsers->first()->is($first))->toBeTrue();
});

it('assigns multiple users to a character without any users', function () {
    $first = User::factory()->active()->create();
    $second = User::factory()->active()->create();

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id, $second->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(2);
    expect($character->activePrimaryUsers)->toHaveCount(0);
    expect($first->characters->first()->is($character))->toBeTrue();
    expect($second->characters->first()->is($character))->toBeTrue();
});

it('assigns multiple users to a character without any users and sets it as the primary character for one of the users', function () {
    $first = User::factory()->active()->create();
    $second = User::factory()->active()->create();

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id, $second->id],
        'primaryUsers' => [$second->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(2);
    expect($character->activePrimaryUsers)->toHaveCount(1);
    expect($first->characters->first()->is($character))->toBeTrue();
    expect($second->characters->first()->is($character))->toBeTrue();
    expect($character->activePrimaryUsers->first()->is($first))->toBeFalse();
    expect($character->activePrimaryUsers->first()->is($second))->toBeTrue();
});

it('assigns multiple users to a character without any users and sets it as the primary character for all users', function () {
    $first = User::factory()->active()->create();
    $second = User::factory()->active()->create();

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id, $second->id],
        'primaryUsers' => [$first->id, $second->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(2);
    expect($character->activePrimaryUsers)->toHaveCount(2);
    expect($first->characters->first()->is($character))->toBeTrue();
    expect($second->characters->first()->is($character))->toBeTrue();
    expect($character->activePrimaryUsers->first()->is($first))->toBeTrue();
    expect($character->activePrimaryUsers->last()->is($second))->toBeTrue();
});

it('adds a user to a character with multiple users', function () {
    $first = User::factory()->active()->create();
    $second = User::factory()->active()->create();
    $third = User::factory()->active()->create();

    $this->character->users()->attach($first);
    $this->character->users()->attach($second);

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id, $second->id, $third->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(3);
    expect($character->activePrimaryUsers)->toHaveCount(0);
    expect($first->characters->first()->is($character))->toBeTrue();
    expect($second->characters->first()->is($character))->toBeTrue();
    expect($third->characters->first()->is($character))->toBeTrue();
});

it('updates the users on a character with existing users', function () {
    $first = User::factory()->active()->create();
    $second = User::factory()->active()->create();
    $third = User::factory()->active()->create();

    $this->character->users()->attach($first);
    $this->character->users()->attach($second);

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id, $third->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(2);
    expect($character->activePrimaryUsers)->toHaveCount(0);
    expect($first->characters->first()->is($character))->toBeTrue();
    expect($second->characters->first())->toBeNull();
    expect($third->characters->first()->is($character))->toBeTrue();
});

it('updates the users on a character with existing users and removes the user with the primary character', function () {
    $first = User::factory()->active()->create();
    $second = User::factory()->active()->create();
    $third = User::factory()->active()->create();

    $this->character->users()->attach($first, ['primary' => true]);
    $this->character->users()->attach($second);
    $this->character->refresh();

    expect($this->character->activePrimaryUsers)->toHaveCount(1);

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id, $third->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(2);
    expect($character->activePrimaryUsers)->toHaveCount(0);
    expect($first->characters->first()->is($character))->toBeTrue();
    expect($second->characters->first())->toBeNull();
    expect($third->characters->first()->is($character))->toBeTrue();
});

it('updates the primary user for a character', function () {
    $first = User::factory()->active()->create();
    $second = User::factory()->active()->create();

    $this->character->users()->attach($first, ['primary' => true]);
    $this->character->users()->attach($second);
    $this->character->refresh();

    expect($this->character->users)->toHaveCount(2);
    expect($this->character->activePrimaryUsers)->toHaveCount(1);
    expect($this->character->activePrimaryUsers->first()->is($first))->toBeTrue();
    expect($this->character->activePrimaryUsers->first()->is($second))->toBeFalse();

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id, $second->id],
        'primaryUsers' => [$second->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(2);
    expect($character->activePrimaryUsers)->toHaveCount(1);
    expect($this->character->activePrimaryUsers->first()->is($first))->toBeFalse();
    expect($this->character->activePrimaryUsers->first()->is($second))->toBeTrue();
});

it('updates the users for a character while changing the primary user for a character', function () {
    $first = User::factory()->active()->create();
    $second = User::factory()->active()->create();
    $third = User::factory()->active()->create();

    $this->character->users()->attach($first, ['primary' => true]);
    $this->character->users()->attach($second);
    $this->character->refresh();

    expect($this->character->users)->toHaveCount(2);
    expect($this->character->activePrimaryUsers)->toHaveCount(1);
    expect($this->character->activePrimaryUsers->first()->is($first))->toBeTrue();
    expect($this->character->activePrimaryUsers->first()->is($second))->toBeFalse();

    $data = AssignCharacterOwnersData::from([
        'users' => [$second->id, $third->id],
        'primaryUsers' => [$third->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(2);
    expect($character->activePrimaryUsers)->toHaveCount(1);
    expect($first->characters->first())->toBeNull();
    expect($second->characters->first()->is($character))->toBeTrue();
    expect($third->characters->first()->is($character))->toBeTrue();
    expect($this->character->activePrimaryUsers->first()->is($second))->toBeFalse();
    expect($this->character->activePrimaryUsers->first()->is($third))->toBeTrue();
});

it('properly updates the primary character of a user', function () {
    $user = User::factory()->active()->create();

    $oldPrimaryCharacter = Character::factory()->active()->create();
    $oldPrimaryCharacter->users()->attach($user, ['primary' => true]);
    $oldPrimaryCharacter->refresh();

    expect($oldPrimaryCharacter->activePrimaryUsers->first()->is($user))->toBeTrue();

    $data = AssignCharacterOwnersData::from([
        'users' => [$user->id],
        'primaryUsers' => [$user->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    $oldPrimaryCharacter->refresh();

    expect($character->users)->toHaveCount(1);
    expect($character->activePrimaryUsers)->toHaveCount(1);
    expect($oldPrimaryCharacter->users)->toHaveCount(1);
    expect($oldPrimaryCharacter->activePrimaryUsers)->toHaveCount(1);
    expect($character->users->first()->is($user))->toBeTrue();
    expect($character->activePrimaryUsers->first()->is($user))->toBeTrue();
    expect($oldPrimaryCharacter->users->first()->is($user))->toBeTrue();
});

it('properly updates the primary character of multiple users', function () {
    $first = User::factory()->active()->create();
    $firstOldPrimaryCharacter = Character::factory()->active()->create();
    $firstOldPrimaryCharacter->users()->attach($first, ['primary' => true]);

    $second = User::factory()->active()->create();
    $secondOldPrimaryCharacter = Character::factory()->active()->create();
    $secondOldPrimaryCharacter->users()->attach($second, ['primary' => true]);

    $data = AssignCharacterOwnersData::from([
        'users' => [$first->id, $second->id],
        'primaryUsers' => [$first->id, $second->id],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    $firstOldPrimaryCharacter->refresh();
    $secondOldPrimaryCharacter->refresh();

    expect($character->users)->toHaveCount(2);
    expect($character->users->where('id', $first->id))->toHaveCount(1);
    expect($character->users->where('id', $second->id))->toHaveCount(1);
    expect($character->activePrimaryUsers)->toHaveCount(2);
    expect((bool) $character->users[0]->pivot->primary)->toBeTrue();
    expect((bool) $character->users[1]->pivot->primary)->toBeTrue();

    expect($firstOldPrimaryCharacter->users)->toHaveCount(1);
    expect($firstOldPrimaryCharacter->users->where('id', $first->id))->toHaveCount(1);
    expect($firstOldPrimaryCharacter->activePrimaryUsers)->toHaveCount(1);

    expect($secondOldPrimaryCharacter->users)->toHaveCount(1);
    expect($secondOldPrimaryCharacter->users->where('id', $second->id))->toHaveCount(1);
    expect($secondOldPrimaryCharacter->activePrimaryUsers)->toHaveCount(1);
});

it('can assign no users to a character', function () {
    $data = AssignCharacterOwnersData::from([
        'users' => [],
    ]);

    $character = AssignCharacterOwners::run($this->character, $data);

    expect($character->users)->toHaveCount(0);
    expect($character->activePrimaryUsers)->toHaveCount(0);
});
