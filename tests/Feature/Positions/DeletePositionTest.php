<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionDeleted;
use Nova\Departments\Livewire\PositionsList;
use Nova\Departments\Models\Position;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('departments');
uses()->group('positions');

beforeEach(function () {
    $this->positions = Position::factory()->count(10)->create();

    signIn(permissions: 'department.delete');
});

test('an authorized user can delete a position', function () {
    Event::fake();

    livewire(PositionsList::class)
        ->callAction(TestAction::make(DeleteAction::class)->table($this->positions->first()))
        ->assertCanNotSeeTableRecords([$this->positions->first()])
        ->assertNotified();

    assertDatabaseMissing(Position::class, $this->positions->first()->toArray());

    Event::assertDispatched(PositionDeleted::class);
});

test('an authorized user can bulk delete positions', function () {
    $positions = $this->positions->take(3);

    livewire(PositionsList::class)
        ->selectTableRecords($positions)
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertCanNotSeeTableRecords($positions)
        ->assertNotified();

    foreach ($positions as $position) {
        assertDatabaseMissing(Position::class, $position->toArray());
    }
});

test('can delete a position with assigned active characters', function () {
    Event::fake();

    $character = \Nova\Characters\Models\Character::factory()->active()->create();
    $position = $this->positions->first();
    $character->positions()->sync([$position->id]);

    livewire(PositionsList::class)
        ->callAction(TestAction::make(DeleteAction::class)->table($position))
        ->assertCanNotSeeTableRecords([$position])
        ->assertNotified();

    assertDatabaseMissing(Position::class, $position->toArray());

    Event::assertDispatched(PositionDeleted::class);
});

test('can delete a position with assigned inactive characters', function () {
    Event::fake();

    $character = \Nova\Characters\Models\Character::factory()->inactive()->create();
    $position = $this->positions->first();
    $character->positions()->sync([$position->id]);

    livewire(PositionsList::class)
        ->callAction(TestAction::make(DeleteAction::class)->table($position))
        ->assertCanNotSeeTableRecords([$position])
        ->assertNotified();

    assertDatabaseMissing(Position::class, $position->toArray());

    Event::assertDispatched(PositionDeleted::class);
});

test('can bulk delete positions with mixed character assignments', function () {
    $positionWithCharacter = $this->positions->first();
    $positionWithoutCharacter = $this->positions->get(1);

    $character = \Nova\Characters\Models\Character::factory()->active()->create();
    $character->positions()->sync([$positionWithCharacter->id]);

    $positions = collect([$positionWithCharacter, $positionWithoutCharacter]);

    livewire(PositionsList::class)
        ->selectTableRecords($positions)
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertCanNotSeeTableRecords($positions)
        ->assertNotified();

    foreach ($positions as $position) {
        assertDatabaseMissing(Position::class, $position->toArray());
    }
});

test('deleting a position removes character assignments', function () {
    $character = \Nova\Characters\Models\Character::factory()->active()->create();
    $position = $this->positions->first();
    $character->positions()->sync([$position->id]);

    expect($character->positions()->count())->toBe(1);

    livewire(PositionsList::class)
        ->callAction(TestAction::make(DeleteAction::class)->table($position))
        ->assertCanNotSeeTableRecords([$position])
        ->assertNotified();

    expect($character->fresh()->positions()->count())->toBe(0);
});
