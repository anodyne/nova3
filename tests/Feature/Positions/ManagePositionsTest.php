<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Livewire\PositionsList;
use Nova\Departments\Models\Position;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('departments');
uses()->group('positions');

beforeEach(function () {
    $this->positions = Position::factory()
        ->count(5)
        ->sequence(
            ['status' => PositionStatus::active, 'available' => 1],
            ['status' => PositionStatus::inactive, 'available' => 0],
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.create');
    });

    test('can view the list positions page', function () {
        get(route('positions.index'))->assertSuccessful();

        livewire(PositionsList::class)
            ->assertCanSeeTableRecords($this->positions);
    });

    test('can filter positions by status', function () {
        livewire(PositionsList::class)
            ->filterTable('status', PositionStatus::active->value)
            ->assertCanSeeTableRecords($this->positions->where('status', PositionStatus::active))
            ->assertCanNotSeeTableRecords($this->positions->where('status', '!=', PositionStatus::active))
            ->resetTableFilters()
            ->filterTable('status', PositionStatus::inactive->value)
            ->assertCanSeeTableRecords($this->positions->where('status', PositionStatus::inactive))
            ->assertCanNotSeeTableRecords($this->positions->where('status', '!=', PositionStatus::inactive));
    });

    test('can filter positions by department', function () {
        livewire(PositionsList::class)
            ->assertCountTableRecords(5)
            ->filterTable('department_id', $this->positions->first()->department_id)
            ->assertCountTableRecords(1);
    });

    test('can filter positions by available slots', function () {
        livewire(PositionsList::class)
            ->assertCountTableRecords(5)
            ->filterTable('available', true)
            ->assertCountTableRecords(3)
            ->resetTableFilters()
            ->filterTable('available', false)
            ->assertCountTableRecords(2);
    });

    test('can filter positions by presence of assigned active characters', function () {
        $character = Character::factory()->active()->create();
        $character->positions()->sync($this->positions->first());

        livewire(PositionsList::class)
            ->assertCountTableRecords(5)
            ->filterTable('assigned_characters', true)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$this->positions->first()])
            ->resetTableFilters()
            ->filterTable('assigned_characters', false)
            ->assertCountTableRecords(4)
            ->assertCanNotSeeTableRecords([$this->positions->first()]);
    });

    test('cannot filter positions by presence of assigned non-active characters', function () {
        $character = Character::factory()->inactive()->create();
        $character->positions()->sync($this->positions->first());

        livewire(PositionsList::class)
            ->assertCountTableRecords(5)
            ->filterTable('assigned_characters', true)
            ->assertCountTableRecords(0);
    });

    test('can search positions by name', function () {
        Position::factory()->create(['name' => 'A test position']);

        livewire(PositionsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->searchTable('test position')
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with department create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.create');
    });

    test('has the correct permissions', function () {
        livewire(PositionsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->positions->first())
            ->assertTableActionHidden(EditAction::class, $this->positions->first())
            ->assertTableActionHidden(DeleteAction::class, $this->positions->first());
    });
});

describe('authorized user with department delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.delete');
    });

    test('has the correct permissions', function () {
        livewire(PositionsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->positions->first())
            ->assertTableActionHidden(EditAction::class, $this->positions->first())
            ->assertTableActionVisible(DeleteAction::class, $this->positions->first());
    });
});

describe('authorized user with department update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.update');
    });

    test('has the correct permissions', function () {
        livewire(PositionsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->positions->first())
            ->assertTableActionVisible(EditAction::class, $this->positions->first())
            ->assertTableActionHidden(DeleteAction::class, $this->positions->first());
    });
});

describe('authorized user with department view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.view');
    });

    test('has the correct permissions', function () {
        livewire(PositionsList::class)
            ->assertTableActionVisible(ViewAction::class, $this->positions->first())
            ->assertTableActionHidden(EditAction::class, $this->positions->first())
            ->assertTableActionHidden(DeleteAction::class, $this->positions->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage positions page', function () {
        get(route('positions.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage positions page', function () {
        get(route('positions.index'))
            ->assertRedirectToRoute('login');
    });
});
