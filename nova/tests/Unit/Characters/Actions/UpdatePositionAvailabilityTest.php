<?php

declare(strict_types=1);

use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Departments\Actions\UpdatePositionAvailability;
use Nova\Departments\Models\Position;

uses()->group('characters');

describe('types are equal, auto-manage is true', function () {
    beforeEach(function () {
        updateSetting(function ($settings) {
            $settings->characters->autoAvailabilityForPrimary = true;
            $settings->characters->autoAvailabilityForSecondary = false;
            $settings->characters->autoAvailabilityForSupport = false;
        });

        $this->character = Character::factory()->active()->primary()->create();

        $this->position1 = Position::factory()->create(['available' => 1]);
        $this->position2 = Position::factory()->create(['available' => 1]);
    });

    it('does not update the availability when there are no position changes', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('updates availability when positions are added', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(0);
    });

    it('updates availability when positions are removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position1->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(2);
    });

    it('updates availability when all positions are removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(2);
        expect($this->position2)->available->toEqual(2);
    });

    it('updates availability when positions are added and removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(2);
        expect($this->position2)->available->toEqual(0);
    });
});

describe('types are equal, auto-manage is false', function () {
    beforeEach(function () {
        updateSetting(function ($settings) {
            $settings->characters->autoAvailabilityForPrimary = false;
            $settings->characters->autoAvailabilityForSecondary = false;
            $settings->characters->autoAvailabilityForSupport = false;
        });

        $this->character = Character::factory()->active()->primary()->create();

        $this->position1 = Position::factory()->create(['available' => 1]);
        $this->position2 = Position::factory()->create(['available' => 1]);
    });

    it('does not update availability when there are no position changes', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('does not update availability when positions are added', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('does not update availability when positions are removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position1->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('does not update availability when all positions are removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('does not update availability when positions are added and removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });
});

describe('types are different, auto-manage is true/true', function () {
    beforeEach(function () {
        updateSetting(function ($settings) {
            $settings->characters->autoAvailabilityForPrimary = true;
            $settings->characters->autoAvailabilityForSecondary = true;
            $settings->characters->autoAvailabilityForSupport = false;
        });

        $this->character = Character::factory()->active()->primary()->create();

        $this->position1 = Position::factory()->create(['available' => 1]);
        $this->position2 = Position::factory()->create(['available' => 1]);
    });

    it('does not update the availability when there are no position changes', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('updates availability when positions are added', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(0);
    });

    it('updates availability when positions are removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position1->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(2);
    });

    it('updates availability when all positions are removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(2);
        expect($this->position2)->available->toEqual(2);
    });

    it('updates availability when positions are added and removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(2);
        expect($this->position2)->available->toEqual(0);
    });
});

describe('types are different, auto-manage is false/false', function () {
    beforeEach(function () {
        updateSetting(function ($settings) {
            $settings->characters->autoAvailabilityForPrimary = false;
            $settings->characters->autoAvailabilityForSecondary = false;
            $settings->characters->autoAvailabilityForSupport = false;
        });

        $this->character = Character::factory()->active()->primary()->create();

        $this->position1 = Position::factory()->create(['available' => 1]);
        $this->position2 = Position::factory()->create(['available' => 1]);
    });

    it('does not update availability when there are no position changes', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('does not update availability when positions are added', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('does not update availability when positions are removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position1->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('does not update availability when all positions are removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });

    it('does not update availability when positions are added and removed', function () {
        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });
});

describe('types are null/not null', function () {
    beforeEach(function () {
        $this->character = Character::factory()->active()->primary()->create();

        $this->position1 = Position::factory()->create(['available' => 1]);
        $this->position2 = Position::factory()->create(['available' => 1]);
    });

    it('updates availability when auto-manage is true', function () {
        updateSetting(function ($settings) {
            $settings->characters->autoAvailabilityForPrimary = true;
            $settings->characters->autoAvailabilityForSecondary = false;
            $settings->characters->autoAvailabilityForSupport = false;
        });

        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: null,
            previousPositions: null,
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(0);
        expect($this->position2)->available->toEqual(0);
    });

    it('does not update availability when auto-manage is false', function () {
        updateSetting(function ($settings) {
            $settings->characters->autoAvailabilityForPrimary = false;
            $settings->characters->autoAvailabilityForSecondary = false;
            $settings->characters->autoAvailabilityForSupport = false;
        });

        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: null,
            previousPositions: null,
            currentType: CharacterType::primary,
            currentPositions: Position::whereIn('id', [$this->position1->id, $this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(1);
    });
});

describe('types are different', function () {
    beforeEach(function () {
        $this->character = Character::factory()->active()->primary()->create();

        $this->position1 = Position::factory()->create(['available' => 1]);
        $this->position2 = Position::factory()->create(['available' => 1]);
    });

    it('updates availability of previous type, but not current type when auto-manage is true/false', function () {
        updateSetting(function ($settings) {
            $settings->characters->autoAvailabilityForPrimary = true;
            $settings->characters->autoAvailabilityForSecondary = false;
            $settings->characters->autoAvailabilityForSupport = false;
        });

        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(2);
        expect($this->position2)->available->toEqual(1);
    });

    it('updates availability of current type, but not previous type when auto-manage is false/true', function () {
        updateSetting(function ($settings) {
            $settings->characters->autoAvailabilityForPrimary = false;
            $settings->characters->autoAvailabilityForSecondary = true;
            $settings->characters->autoAvailabilityForSupport = false;
        });

        $positions = new CharacterPositionsData(
            character: $this->character,
            previousType: CharacterType::primary,
            previousPositions: Position::whereIn('id', [$this->position1->id])->get(),
            currentType: CharacterType::secondary,
            currentPositions: Position::whereIn('id', [$this->position2->id])->get()
        );

        UpdatePositionAvailability::run($positions);

        $this->position1->refresh();
        $this->position2->refresh();

        expect($this->position1)->available->toEqual(1);
        expect($this->position2)->available->toEqual(0);
    });
});

it('cannot set availability below zero', function () {
    updateSetting(function ($settings) {
        $settings->characters->autoAvailabilityForPrimary = true;
        $settings->characters->autoAvailabilityForSecondary = false;
        $settings->characters->autoAvailabilityForSupport = false;
    });

    $character = Character::factory()->active()->primary()->create();

    $position1 = Position::factory()->create(['available' => 0]);

    $positions = new CharacterPositionsData(
        character: $character,
        previousType: CharacterType::primary,
        previousPositions: Position::whereIn('id', [])->get(),
        currentType: CharacterType::primary,
        currentPositions: Position::whereIn('id', [$position1->id])->get()
    );

    UpdatePositionAvailability::run($positions);

    $position1->refresh();

    expect($position1)->available->toEqual(0);
});
