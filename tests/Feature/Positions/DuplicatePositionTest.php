<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Departments\Events\PositionDuplicated;
use Nova\Departments\Livewire\PositionsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Filament\Actions\ReplicateAction;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('departments');
uses()->group('positions');

beforeEach(function () {
    $this->position = Position::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: ['department.create', 'department.update']);
    });

    test('can duplicate a position', function () {
        Event::fake();

        $data = [
            'name' => 'New position name',
        ];

        livewire(PositionsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->position), data: $data)
            ->assertHasNoFormErrors()
            ->assertNotified();

        $newPosition = Position::latest('id')->first();

        assertDatabaseHas(Position::class, $newPosition->only('id', 'name'));

        Event::assertDispatched(PositionDuplicated::class);
    });

    test('can change department when duplicating', function () {
        Event::fake();

        $newDepartment = Department::factory()->create();

        $data = [
            'name' => 'Duplicated position',
            'department_id' => $newDepartment->id,
        ];

        livewire(PositionsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->position), data: $data)
            ->assertHasNoFormErrors()
            ->assertNotified();

        $newPosition = Position::latest('id')->first();

        assertDatabaseHas(Position::class, [
            'id' => $newPosition->id,
            'name' => 'Duplicated position',
            'department_id' => $newDepartment->id,
        ]);
    });

    it('validates inputs', function () {
        livewire(PositionsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->position), data: [
                'name' => '',
                'department_id' => $this->position->department_id,
            ])
            ->assertHasFormErrors(['name']);

        livewire(PositionsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->position), data: [
                'name' => 'Foo',
                'department_id' => '',
            ])
            ->assertHasFormErrors(['department_id']);
    });
});

describe('unauthorized user', function () {
    test('cannot duplicate with only create permission', function () {
        signIn(permissions: 'department.create');

        livewire(PositionsList::class)
            ->assertActionHidden(TestAction::make(ReplicateAction::class)->table($this->position));
    });

    test('cannot duplicate with only update permission', function () {
        signIn(permissions: 'department.update');

        livewire(PositionsList::class)
            ->assertActionHidden(TestAction::make(ReplicateAction::class)->table($this->position));
    });

    test('cannot duplicate without permissions', function () {
        signIn();

        livewire(PositionsList::class)
            ->assertActionHidden(TestAction::make(ReplicateAction::class)->table($this->position));
    });
});

describe('duplicated position', function () {
    beforeEach(function () {
        signIn(permissions: ['department.create', 'department.update']);
    });

    test('preserves data from original', function () {
        Event::fake();

        $data = [
            'name' => 'Duplicated position',
            'department_id' => $this->position->department_id,
        ];

        livewire(PositionsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->position), data: $data)
            ->assertHasNoFormErrors()
            ->assertNotified();

        $newPosition = Position::latest('id')->first();

        assertDatabaseHas(Position::class, [
            'id' => $newPosition->id,
            'name' => 'Duplicated position',
            'department_id' => $this->position->department_id,
            'description' => $this->position->description,
            'available' => $this->position->available,
            'status' => $this->position->status,
            'tags' => $this->position->tags,
        ]);
    });

    test('does not copy assigned characters from original position', function () {
        Event::fake();

        $character = Character::factory()->active()->create();
        $character->positions()->sync([$this->position->id]);

        expect($this->position->activeCharacters()->count())->toBe(1);

        $data = [
            'name' => 'Duplicated position',
            'department_id' => $this->position->department_id,
        ];

        livewire(PositionsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->position), data: $data)
            ->assertHasNoFormErrors()
            ->assertNotified();

        $newPosition = Position::latest('id')->first();

        expect($newPosition->activeCharacters()->count())->toBe(0);
    });
});
