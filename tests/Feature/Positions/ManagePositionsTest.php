<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Nova\Characters\Models\Character;
use Nova\Departments\Livewire\PositionsList;
use Nova\Departments\Models\Position;
use Nova\Foundation\Enums\BasicStatus;
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
            ['status' => BasicStatus::Active, 'available' => 1],
            ['status' => BasicStatus::Inactive, 'available' => 0],
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.create');
    });

    test('can view the list positions page', function () {
        get(route('admin.positions.index'))->assertSuccessful();

        livewire(PositionsList::class)
            ->assertCanSeeTableRecords($this->positions);
    });

    test('can filter positions by status', function () {
        livewire(PositionsList::class)
            ->filterTable('status', BasicStatus::Active->value)
            ->assertCanSeeTableRecords($this->positions->where('status', BasicStatus::Active))
            ->assertCanNotSeeTableRecords($this->positions->where('status', '!=', BasicStatus::Active))
            ->resetTableFilters()
            ->filterTable('status', BasicStatus::Inactive->value)
            ->assertCanSeeTableRecords($this->positions->where('status', BasicStatus::Inactive))
            ->assertCanNotSeeTableRecords($this->positions->where('status', '!=', BasicStatus::Inactive));
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

    test('table displays available slots column', function () {
        $position = Position::factory()->create(['available' => 7]);

        livewire(PositionsList::class)
            ->assertCanSeeTableRecords([$position])
            ->assertTableColumnExists('available');
    });

    test('table displays active characters count column', function () {
        $position = Position::factory()->create();
        $character = Character::factory()->active()->create();
        $character->positions()->sync([$position->id]);

        livewire(PositionsList::class)
            ->assertCanSeeTableRecords([$position])
            ->assertTableColumnExists('active_characters_count');
    });

    test('table displays active users count column', function () {
        livewire(PositionsList::class)
            ->assertTableColumnExists('active_users_count');
    });

    test('table displays status badge', function () {
        $activePosition = Position::factory()->active()->create();
        $inactivePosition = Position::factory()->inactive()->create();

        livewire(PositionsList::class)
            ->assertCanSeeTableRecords([$activePosition, $inactivePosition])
            ->assertTableColumnExists('status');
    });

    test('table can be sorted by name', function () {
        livewire(PositionsList::class)
            ->sortTable('name')
            ->assertCanSeeTableRecords($this->positions, inOrder: true);
    });

    test('table can be sorted by available slots', function () {
        livewire(PositionsList::class)
            ->sortTable('available')
            ->assertSuccessful();
    });

    test('table displays empty state when no positions', function () {
        Position::query()->delete();

        livewire(PositionsList::class)
            ->assertSeeText('No positions found');
    });
});

describe('authorized user with department create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.create');
    });

    test('has the correct permissions', function () {
        $position = $this->positions->first();

        livewire(PositionsList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($position))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($position))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($position));
    });

});

describe('authorized user with department delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.delete');
    });

    test('has the correct permissions', function () {
        $position = $this->positions->first();

        livewire(PositionsList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($position))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($position))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($position));
    });
});

describe('authorized user with department update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.update');
    });

    test('has the correct permissions', function () {
        $position = $this->positions->first();

        livewire(PositionsList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($position))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($position))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($position));
    });
});

describe('authorized user with department view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'department.view');
    });

    test('has the correct permissions', function () {
        $position = $this->positions->first();

        livewire(PositionsList::class)
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($position))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($position))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($position));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage positions page', function () {
        get(route('admin.positions.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage positions page', function () {
        get(route('admin.positions.index'))
            ->assertRedirectToRoute('login');
    });
});
