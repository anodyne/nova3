<?php

declare(strict_types=1);

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
        ->callTableAction(DeleteAction::class, $this->positions->first())
        ->assertCanNotSeeTableRecords([$this->positions->first()])
        ->assertNotified();

    assertDatabaseMissing(Position::class, $this->positions->first()->toArray());

    Event::assertDispatched(PositionDeleted::class);
});

test('an authorized user can bulk delete positions', function () {
    $positions = $this->positions->take(3);

    livewire(PositionsList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $positions)
        ->assertNotified();

    foreach ($positions as $position) {
        assertDatabaseMissing(Position::class, $position->toArray());
    }
});
