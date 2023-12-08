<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentDeleted;
use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Models\Department;
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

    livewire(DepartmentsList::class)
        ->callTableAction(DeleteAction::class, $this->departments->first())
        ->assertCanNotSeeTableRecords([$this->departments->first()])
        ->assertNotified();

    assertDatabaseMissing(Department::class, $this->departments->first()->toArray());

    Event::assertDispatched(DepartmentDeleted::class);
});

test('an authorized user can bulk delete departments', function () {
    $departments = $this->departments->take(3);

    livewire(DepartmentsList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $departments)
        ->assertNotified();

    foreach ($departments as $department) {
        assertDatabaseMissing(Department::class, $department->toArray());
    }
});
