<?php

declare(strict_types=1);
use Nova\Characters\Actions\AssignCharacterPositions;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->active()->create();
});
it('assigns one position to a character without any positions', function () {
    $position = Position::factory()->create();

    $data = AssignCharacterPositionsData::from([
        'positions' => [$position->id],
    ]);

    $character = AssignCharacterPositions::run($this->character, $data);

    $position->refresh();

    expect($character->positions)->toHaveCount(1);
    expect($character->positions->first()->is($position))->toBeTrue();
});
it('assigns multiple positions to a character without any positions', function () {
    $first = Position::factory()->create();
    $second = Position::factory()->create();

    $data = AssignCharacterPositionsData::from([
        'positions' => [$first->id, $second->id],
    ]);

    $character = AssignCharacterPositions::run($this->character, $data);

    $first->refresh();
    $second->refresh();

    expect($character->positions)->toHaveCount(2);
    expect($first->characters->first()->is($character))->toBeTrue();
    expect($second->characters->first()->is($character))->toBeTrue();
});
it('assigns one position to a character with a different position', function () {
    $first = Position::factory()->create();
    $second = Position::factory()->create();

    $this->character->positions()->attach($first);

    $this->character->refresh();

    expect($this->character->positions)->toHaveCount(1);

    $data = AssignCharacterPositionsData::from([
        'positions' => [$second->id],
    ]);

    $character = AssignCharacterPositions::run($this->character, $data);

    $first->refresh();
    $second->refresh();

    expect($character->positions)->toHaveCount(1);
    expect($character->positions->first()->is($first))->toBeFalse();
    expect($character->positions->first()->is($second))->toBeTrue();
});
