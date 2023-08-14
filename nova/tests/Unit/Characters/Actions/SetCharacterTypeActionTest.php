<?php

declare(strict_types=1);
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

uses()->group('characters');

it('can set a primary character as a secondary character', function () {
    $character = Character::factory()->primary()->create();
    $user = User::factory()->active()->create();
    $character->users()->attach($user);

    $character = SetCharacterType::run($character);

    expect($character->type)->toEqual(CharacterType::secondary);
});
it('can set a support character as a secondary character', function () {
    $character = Character::factory()->support()->create();
    $user = User::factory()->active()->create();
    $character->users()->attach($user);

    $character = SetCharacterType::run($character);

    expect($character->type)->toEqual(CharacterType::secondary);
});
it('can set a secondary character as a primary character', function () {
    $character = Character::factory()->secondary()->create();
    $user = User::factory()->active()->create();
    $character->users()->attach($user, ['primary' => true]);

    $character = SetCharacterType::run($character);

    expect($character->type)->toEqual(CharacterType::primary);
});
it('can set a support character as a primary character', function () {
    $character = Character::factory()->support()->create();
    $user = User::factory()->active()->create();
    $character->users()->attach($user, ['primary' => true]);

    $character = SetCharacterType::run($character);

    expect($character->type)->toEqual(CharacterType::primary);
});
it('can set a primary character as a support character', function () {
    $character = Character::factory()->primary()->create();

    $character = SetCharacterType::run($character);

    expect($character->type)->toEqual(CharacterType::support);
});
it('can set a secondary character as a support character', function () {
    $character = Character::factory()->secondary()->create();

    $character = SetCharacterType::run($character);

    expect($character->type)->toEqual(CharacterType::support);
});
