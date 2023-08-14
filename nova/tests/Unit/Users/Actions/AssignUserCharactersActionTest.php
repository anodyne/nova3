<?php

declare(strict_types=1);
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Actions\AssignUserCharacters;
use Nova\Users\Data\AssignUserCharactersData;
use Nova\Users\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
it('assigns a character to a user without any characters and does not set the primary character', function () {
    $jackSparrow = Character::factory()->active()->create();

    $data = AssignUserCharactersData::from([
        'characters' => [$jackSparrow->id],
    ]);

    $user = AssignUserCharacters::run($this->user, $data);

    $jackSparrow->refresh();

    expect($user->characters)->toHaveCount(1);
    expect($user->characters->where('id', $jackSparrow->id))->toHaveCount(1);
    expect($jackSparrow->type)->toEqual(CharacterType::secondary);
});
it('assigns a character to a user without any characters and sets the primary character', function () {
    $jackSparrow = Character::factory()->active()->create();

    $data = AssignUserCharactersData::from([
        'characters' => [$jackSparrow->id],
        'primaryCharacter' => $jackSparrow,
    ]);

    $user = AssignUserCharacters::run($this->user, $data);

    $jackSparrow->refresh();

    expect($user->characters)->toHaveCount(1);
    expect($user->characters->where('id', $jackSparrow->id))->toHaveCount(1);
    expect((bool) $user->primaryCharacter[0]->pivot->primary)->toBeTrue();
    expect($jackSparrow->type)->toEqual(CharacterType::primary);
});
it('assigns a character to a user with existing character', function () {
    $jackSparrow = Character::factory()->active()->create();
    $willTurner = Character::factory()->active()->create();

    $data = AssignUserCharactersData::from([
        'characters' => [$jackSparrow->id, $willTurner->id],
        'primaryCharacter' => $jackSparrow,
    ]);

    $user = AssignUserCharacters::run($this->user, $data);

    $jackSparrow->refresh();
    $willTurner->refresh();

    expect($user->characters)->toHaveCount(2);

    expect($user->characters->where('id', $jackSparrow->id))->toHaveCount(1);
    expect((bool) $user->characters->where('id', $jackSparrow->id)->first()->pivot->primary)->toBeTrue();
    expect($jackSparrow->type)->toEqual(CharacterType::primary);

    expect($user->characters->where('id', $willTurner->id))->toHaveCount(1);
    expect((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary)->toBeFalse();
    expect($willTurner->type)->toEqual(CharacterType::secondary);
});
it('assigns a character to a user with existing character and changes the primary character', function () {
    $jackSparrow = Character::factory()->active()->create();
    $willTurner = Character::factory()->active()->create();

    $data = AssignUserCharactersData::from([
        'characters' => [$jackSparrow->id, $willTurner->id],
        'primaryCharacter' => $willTurner,
    ]);

    $user = AssignUserCharacters::run($this->user, $data);

    $jackSparrow->refresh();
    $willTurner->refresh();

    expect($user->characters)->toHaveCount(2);

    expect($user->characters->where('id', $jackSparrow->id))->toHaveCount(1);
    expect((bool) $user->characters->where('id', $jackSparrow->id)->first()->pivot->primary)->toBeFalse();
    expect($jackSparrow->type)->toEqual(CharacterType::secondary);

    expect($user->characters->where('id', $willTurner->id))->toHaveCount(1);
    expect((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary)->toBeTrue();
    expect($willTurner->type)->toEqual(CharacterType::primary);
});
it('removes an assigned character from a user', function () {
    $jackSparrow = Character::factory()->active()->create();
    $willTurner = Character::factory()->active()->create();

    $this->user->characters()->sync([$jackSparrow->id, $willTurner->id]);

    $data = AssignUserCharactersData::from([
        'characters' => [$willTurner->id],
    ]);

    $user = AssignUserCharacters::run($this->user, $data);

    $jackSparrow->refresh();
    $willTurner->refresh();

    expect($user->characters)->toHaveCount(1);

    expect($user->characters->where('id', $jackSparrow->id))->toHaveCount(0);
    expect($jackSparrow->type)->toEqual(CharacterType::support);

    expect($user->characters->where('id', $willTurner->id))->toHaveCount(1);
    expect((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary)->toBeFalse();
    expect($willTurner->type)->toEqual(CharacterType::secondary);
});
it('adds and removes characters from a user', function () {
    $jackSparrow = Character::factory()->active()->create();
    $willTurner = Character::factory()->active()->create();
    $elizabethSwann = Character::factory()->active()->create();

    $this->user->characters()->sync([$jackSparrow->id, $willTurner->id]);

    $data = AssignUserCharactersData::from([
        'characters' => [$willTurner->id, $elizabethSwann->id],
        'primaryCharacter' => $elizabethSwann,
    ]);

    $user = AssignUserCharacters::run($this->user, $data);

    $jackSparrow->refresh();
    $willTurner->refresh();
    $elizabethSwann->refresh();

    expect($user->characters)->toHaveCount(2);

    expect($user->characters->where('id', $jackSparrow->id))->toHaveCount(0);
    expect($jackSparrow->type)->toEqual(CharacterType::support);

    expect($user->characters->where('id', $willTurner->id))->toHaveCount(1);
    expect((bool) $user->characters->where('id', $willTurner->id)->first()->pivot->primary)->toBeFalse();
    expect($willTurner->type)->toEqual(CharacterType::secondary);

    expect($user->characters->where('id', $elizabethSwann->id))->toHaveCount(1);
    expect((bool) $user->characters->where('id', $elizabethSwann->id)->first()->pivot->primary)->toBeTrue();
    expect($elizabethSwann->type)->toEqual(CharacterType::primary);
});
