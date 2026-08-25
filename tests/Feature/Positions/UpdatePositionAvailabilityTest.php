<?php

declare(strict_types=1);

use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\CharacterPosition;
use Nova\Departments\Actions\UpdatePositionAvailability;
use Nova\Departments\Models\Position;

use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

uses()->group('positions');

it('decrements position availability when character is activated', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 1]);
    $character = Character::factory()->inactive()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'inactive',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 0,
    ]);
});

it('decrements multiple position availability when character is activated', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 1]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->inactive()->primary()->create();
    $character->positions()->attach([$position1, $position2]);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'inactive',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 0,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 0,
    ]);
});

it('does not decrement when character is activated but auto-manage is disabled', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: false
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 1]);
    $character = Character::factory()->inactive()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'inactive',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 1,
    ]);
});

it('does not decrement when character status does not change', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 1]);
    $character = Character::factory()->inactive()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'inactive',
        newStatus: 'inactive'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 1,
    ]);
});

it('increments position availability when character is deactivated', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 0]);
    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'inactive'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 1,
    ]);
});

it('increments multiple position availability when character is deactivated', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 0]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach([$position1, $position2]);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'inactive'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 1,
    ]);
});

it('does not increment when character is deactivated but auto-manage is disabled', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: false
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 1]);
    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'inactive'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 1,
    ]);
});

it('decrements position availability when new character is created', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 1]);
    $character = Character::factory()->pending()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: null,
        newType: CharacterType::Primary,
        oldPositions: null,
        newPositions: $character->positions,
        oldStatus: 'pending',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 0,
    ]);
});

it('decrements multiple position availability when new character is created with multiple positions', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 1]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->pending()->primary()->create();
    $character->positions()->attach([$position1, $position2]);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: null,
        newType: CharacterType::Primary,
        oldPositions: null,
        newPositions: $character->positions,
        oldStatus: 'pending',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 0,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 0,
    ]);
});

it('does not decrement when new character is created but auto-manage is disabled', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: false
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 1]);
    $character = Character::factory()->pending()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: null,
        newType: CharacterType::Primary,
        oldPositions: null,
        newPositions: $character->positions,
        oldStatus: 'pending',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 1,
    ]);
});

it('handles new character with no positions assigned', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $character = Character::factory()->pending()->primary()->create();

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: null,
        newType: CharacterType::Primary,
        oldPositions: null,
        newPositions: null,
        oldStatus: 'pending',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseEmpty(CharacterPosition::class);
});

it('decrements new positions when character changes positions with the same type', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position1);

    $oldPositions = $character->positions;

    $character->positions()->detach($position1);
    $character->positions()->attach($position2);
    $character->refresh();

    $newPositions = $character->positions;

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $oldPositions,
        newPositions: $newPositions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 0,
    ]);
});

it('handles adding positions (keeping same old ones)', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position1);

    $oldPositions = $character->positions;

    $character->positions()->attach($position2);
    $character->refresh();

    $newPositions = $character->positions;

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $oldPositions,
        newPositions: $newPositions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 0,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 0,
    ]);
});

it('handles removing positions (keeping some)', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 0]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach([$position1, $position2]);

    $oldPositions = $character->positions;

    $character->positions()->detach($position2);
    $character->refresh();

    $newPositions = $character->positions;

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $oldPositions,
        newPositions: $newPositions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 0,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 1,
    ]);
});

it('handles complete position swap', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 0]);
    $position3 = Position::factory()->active()->create(['available' => 1]);
    $position4 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach([$position1, $position2]);

    $oldPositions = $character->positions;

    $character->positions()->detach([$position1, $position2]);
    $character->positions()->attach([$position3, $position4]);
    $character->refresh();

    $newPositions = $character->positions;

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $oldPositions,
        newPositions: $newPositions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position3->id,
        'available' => 0,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position4->id,
        'available' => 0,
    ]);
});

it('does not change availability when positions unchanged with the same type', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 0]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 0,
    ]);
});

it('decrements new positions when type and positions both change', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true,
            autoAvailabilityForSecondary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position1);

    $oldPositions = $character->positions;

    $character->positions()->detach($position1);
    $character->positions()->attach($position2);
    $character->refresh();

    $newPositions = $character->positions;

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Secondary,
        newType: $character->type,
        oldPositions: $oldPositions,
        newPositions: $newPositions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 0,
    ]);
});

it('decrements when changing from non-managed to managed type', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true,
            autoAvailabilityForSupport: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position1);

    $oldPositions = $character->positions;

    $character->positions()->detach($position1);
    $character->positions()->attach($position2);
    $character->refresh();

    $newPositions = $character->positions;

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Support,
        newType: $character->type,
        oldPositions: $oldPositions,
        newPositions: $newPositions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 0,
    ]);
});

it('does not decrement when changing from managed to non-managed type', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true,
            autoAvailabilityForSupport: false
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->support()->create();
    $character->positions()->attach($position1);

    $oldPositions = $character->positions;

    $character->positions()->detach($position1);
    $character->positions()->attach($position2);
    $character->refresh();

    $newPositions = $character->positions;

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $oldPositions,
        newPositions: $newPositions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 1,
    ]);
});

it('increments old positions when type and positions both change', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true,
            autoAvailabilityForSecondary: true
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->secondary()->create();
    $character->positions()->attach($position1);

    $oldPositions = $character->positions;

    $character->positions()->detach($position1);
    $character->positions()->attach($position2);
    $character->refresh();

    $newPositions = $character->positions;

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $oldPositions,
        newPositions: $newPositions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 0,
    ]);
});

it('decrements all positions when changing from non-managed to managed type', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true,
            autoAvailabilityForSupport: false
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Support,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 0,
    ]);
});

it('handles multiple positions when changing to managed type', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true,
            autoAvailabilityForSupport: false
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 1]);
    $position2 = Position::factory()->active()->create(['available' => 1]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach([$position1, $position2]);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Support,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 0,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 0,
    ]);
});

it('increments all positions when changing from managed to non-managed type', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true,
            autoAvailabilityForSupport: false
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 0]);

    $character = Character::factory()->active()->support()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 1,
    ]);
});

it('handles multiple positions when changing to non-managed type', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true,
            autoAvailabilityForSupport: false
        );

        return $settings;
    });

    $position1 = Position::factory()->active()->create(['available' => 0]);
    $position2 = Position::factory()->active()->create(['available' => 0]);

    $character = Character::factory()->active()->support()->create();
    $character->positions()->attach([$position1, $position2]);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position1->id,
        'available' => 1,
    ]);

    assertDatabaseHas(Position::class, [
        'id' => $position2->id,
        'available' => 1,
    ]);
});

it('cannot decrement availability below 0', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 0]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: null,
        newPositions: $character->positions,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 0,
    ]);
});

it('handles character with null new positions', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $position = Position::factory()->active()->create(['available' => 0]);

    $character = Character::factory()->active()->primary()->create();
    $character->positions()->attach($position);

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: $character->positions,
        newPositions: null,
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseHas(Position::class, [
        'id' => $position->id,
        'available' => 1,
    ]);
});

it('handles character with empty collections', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $character = Character::factory()->active()->primary()->create();

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: collect([]),
        newPositions: collect([]),
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseEmpty(CharacterPosition::class);
});

it('handles positions that do not exist in the database', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            autoAvailabilityForPrimary: true
        );

        return $settings;
    });

    $character = Character::factory()->active()->primary()->create();
    $position = Position::factory()->create();
    $position->delete();

    $data = CharacterPositionsData::from(
        character: $character,
        oldType: CharacterType::Primary,
        newType: $character->type,
        oldPositions: null,
        newPositions: collect([$position]),
        oldStatus: 'active',
        newStatus: 'active'
    );

    UpdatePositionAvailability::run($data);

    assertDatabaseEmpty(CharacterPosition::class);
});
