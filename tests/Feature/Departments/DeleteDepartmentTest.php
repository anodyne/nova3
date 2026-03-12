<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentDeleted;
use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('departments');

beforeEach(function () {
    $this->departments = Department::factory()->count(10)->create();

    signIn(permissions: 'department.delete');
});

test('an authorized user can delete a department', function () {
    Event::fake();

    $department = $this->departments->first();

    livewire(DepartmentsList::class)
        ->callAction(TestAction::make(DeleteAction::class)->table($department))
        ->assertCanNotSeeTableRecords([$department])
        ->assertNotified();

    assertDatabaseMissing(Department::class, [
        'id' => $department->id,
    ]);

    assertDatabaseMissing(Position::class, [
        'department_id' => $department->id,
    ]);

    Event::assertDispatched(DepartmentDeleted::class);
});

test('an authorized user can bulk delete departments', function () {
    $departments = $this->departments->take(3);

    livewire(DepartmentsList::class)
        ->selectTableRecords($departments)
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertCanNotSeeTableRecords($departments)
        ->assertNotified();

    foreach ($departments as $department) {
        assertDatabaseMissing(Department::class, [
            'id' => $department->id,
        ]);

        assertDatabaseMissing(Position::class, [
            'department_id' => $department->id,
        ]);
    }
});
