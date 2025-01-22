<?php

declare(strict_types=1);

use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Models\Department;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('departments');

beforeEach(function () {
    $this->departments = Department::factory()
        ->count(5)
        ->hasPositions(3)
        ->sequence(
            ['status' => BasicStatus::Active],
            ['status' => BasicStatus::Inactive],
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.create');
    });

    test('can view the list departments page', function () {
        get(route('admin.departments.index'))->assertSuccessful();

        livewire(DepartmentsList::class)
            ->assertCanSeeTableRecords($this->departments);
    });

    test('can filter departments by status', function () {
        livewire(DepartmentsList::class)
            ->filterTable('status', BasicStatus::Active->value)
            ->assertCanSeeTableRecords($this->departments->where('status', BasicStatus::Active))
            ->assertCanNotSeeTableRecords($this->departments->where('status', '!=', BasicStatus::Active))
            ->resetTableFilters()
            ->filterTable('status', BasicStatus::Inactive->value)
            ->assertCanSeeTableRecords($this->departments->where('status', BasicStatus::Inactive))
            ->assertCanNotSeeTableRecords($this->departments->where('status', '!=', BasicStatus::Inactive));
    });

    test('can filter departments by the presence of positions', function () {
        Department::factory()->create();

        livewire(DepartmentsList::class)
            ->filterTable('has_positions', true)
            ->assertCountTableRecords(5)
            ->resetTableFilters()
            ->filterTable('has_positions', false)
            ->assertCountTableRecords(1);
    });

    test('can search departments by name', function () {
        Department::factory()->create(['name' => 'A test department']);

        livewire(DepartmentsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->searchTable('test department')
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with department create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.create');
    });

    test('has the correct permissions', function () {
        livewire(DepartmentsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->departments->first())
            ->assertTableActionHidden(EditAction::class, $this->departments->first())
            ->assertTableActionHidden(DeleteAction::class, $this->departments->first())
            ->assertTableActionVisible('positions', $this->departments->first());
    });
});

describe('authorized user with department delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.delete');
    });

    test('has the correct permissions', function () {
        livewire(DepartmentsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->departments->first())
            ->assertTableActionHidden(EditAction::class, $this->departments->first())
            ->assertTableActionVisible(DeleteAction::class, $this->departments->first())
            ->assertTableActionVisible('positions', $this->departments->first());
    });
});

describe('authorized user with department update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.update');
    });

    test('has the correct permissions', function () {
        livewire(DepartmentsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->departments->first())
            ->assertTableActionVisible(EditAction::class, $this->departments->first())
            ->assertTableActionHidden(DeleteAction::class, $this->departments->first())
            ->assertTableActionVisible('positions', $this->departments->first());
    });
});

describe('authorized user with department view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.view');
    });

    test('has the correct permissions', function () {
        livewire(DepartmentsList::class)
            ->assertTableActionVisible(ViewAction::class, $this->departments->first())
            ->assertTableActionHidden(EditAction::class, $this->departments->first())
            ->assertTableActionHidden(DeleteAction::class, $this->departments->first())
            ->assertTableActionVisible('positions', $this->departments->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage departments page', function () {
        get(route('admin.departments.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage departments page', function () {
        get(route('admin.departments.index'))
            ->assertRedirectToRoute('login');
    });
});
