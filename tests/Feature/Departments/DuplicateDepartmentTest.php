<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentDuplicated;
use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Filament\Actions\ReplicateAction;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('departments');

beforeEach(function () {
    $this->department = Department::factory()
        ->hasPositions(5)
        ->create();

    signIn(permissions: ['department.create', 'department.update']);
});

test('an authorized user can duplicate a department', function () {
    Event::fake();

    $data = [
        'name' => 'New department name',
    ];

    livewire(DepartmentsList::class)
        ->callTableAction(ReplicateAction::class, $this->department, data: $data)
        ->assertNotified();

    $newDepartment = Department::latest('id')->first();

    assertDatabaseHas(Department::class, $newDepartment->only('id', 'name'));

    assertDatabaseHas(Position::class, ['department_id' => $newDepartment->id]);

    Event::assertDispatched(DepartmentDuplicated::class);
});
