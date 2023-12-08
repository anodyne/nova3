<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionDuplicated;
use Nova\Departments\Livewire\PositionsList;
use Nova\Departments\Models\Position;
use Nova\Foundation\Filament\Actions\ReplicateAction;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('departments');
uses()->group('positions');

beforeEach(function () {
    $this->position = Position::factory()->create();

    signIn(permissions: ['department.create', 'department.update']);
});

test('an authorized user can duplicate a position', function () {
    Event::fake();

    $data = [
        'name' => 'New position name',
    ];

    livewire(PositionsList::class)
        ->callTableAction(ReplicateAction::class, $this->position, data: $data)
        ->assertNotified();

    $newPosition = Position::latest('id')->first();

    assertDatabaseHas(Position::class, $newPosition->only('id', 'name'));

    Event::assertDispatched(PositionDuplicated::class);
});
