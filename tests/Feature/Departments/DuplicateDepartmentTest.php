<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentDuplicated;
use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Filament\Actions\ReplicateAction;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\castAsJson;
use function Pest\Livewire\livewire;

uses()->group('departments');

beforeEach(function () {
    $this->department = Department::factory()
        ->hasPositions(5)
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: ['department.create', 'department.update']);
    });

    test('can duplicate a department', function () {
        Event::fake();

        $data = [
            'name' => 'New department name',
        ];

        livewire(DepartmentsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->department), data: $data)
            ->assertNotified();

        $newDepartment = Department::latest('id')->first();

        assertDatabaseHas(Department::class, $this->department->only('id', 'name'));
        assertDatabaseHas(Department::class, $newDepartment->only('id', 'name'));

        assertDatabaseHas(Position::class, ['department_id' => $this->department->id]);
        assertDatabaseHas(Position::class, ['department_id' => $newDepartment->id]);

        Event::assertDispatched(DepartmentDuplicated::class);
    });

    it('validates inputs', function () {
        livewire(DepartmentsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->department), data: [
                'name' => '',
            ])
            ->assertHasFormErrors(['name']);
    });
});

describe('unauthorized user', function () {
    test('cannot duplicate with only create permission', function () {
        signIn(permissions: 'department.create');

        livewire(DepartmentsList::class)
            ->assertActionHidden(TestAction::make(ReplicateAction::class)->table($this->department));
    });

    test('cannot duplicate with only update permission', function () {
        signIn(permissions: 'department.update');

        livewire(DepartmentsList::class)
            ->assertActionHidden(TestAction::make(ReplicateAction::class)->table($this->department));
    });

    test('cannot duplicate without permissions', function () {
        signIn();

        livewire(DepartmentsList::class)
            ->assertActionHidden(TestAction::make(ReplicateAction::class)->table($this->department));
    });
});

describe('duplicated department', function () {
    beforeEach(function () {
        signIn(permissions: ['department.create', 'department.update']);
    });

    test('preserves data from original', function () {
        Event::fake();

        $data = [
            'name' => 'Duplicated department',
        ];

        livewire(DepartmentsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->department), data: $data)
            ->assertHasNoFormErrors()
            ->assertNotified();

        $newDepartment = Department::latest('id')->first();

        assertDatabaseHas(Department::class, [
            'id' => $newDepartment->id,
            'name' => 'Duplicated department',
            'description' => $this->department->description,
            'status' => $this->department->status,
            'tags' => castAsJson([]),
        ]);
    });

    test('duplicates positions from original department', function () {
        Event::fake();

        expect($this->department->positions()->count())->toBe(5);

        $data = [
            'name' => 'Duplicated department',
        ];

        livewire(DepartmentsList::class)
            ->callAction(TestAction::make(ReplicateAction::class)->table($this->department), data: $data)
            ->assertHasNoFormErrors()
            ->assertNotified();

        $newDepartment = Department::latest('id')->first();

        expect($this->department->positions()->count())->toBe(5);
        expect($newDepartment->positions()->count())->toBe(5);
    });
});
