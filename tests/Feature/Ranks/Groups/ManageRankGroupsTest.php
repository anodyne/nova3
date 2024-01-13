<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Ranks\Enums\RankGroupStatus;
use Nova\Ranks\Livewire\RankGroupsList;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('ranks');

beforeEach(function () {
    $this->rankGroups = RankGroup::factory()
        ->count(10)
        ->sequence(
            ['status' => RankGroupStatus::active],
            ['status' => RankGroupStatus::inactive],
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the list rank groups page', function () {
        get(route('ranks.groups.index'))->assertSuccessful();

        livewire(RankGroupsList::class)
            ->assertCanSeeTableRecords($this->rankGroups);
    });

    test('can filter rank groups by status', function () {
        livewire(RankGroupsList::class)
            ->filterTable('status', RankGroupStatus::active->value)
            ->assertCanSeeTableRecords($this->rankGroups->where('status', RankGroupStatus::active))
            ->assertCanNotSeeTableRecords($this->rankGroups->where('status', RankGroupStatus::inactive))
            ->filterTable('status', RankGroupStatus::inactive->value)
            ->assertCanSeeTableRecords($this->rankGroups->where('status', RankGroupStatus::inactive))
            ->assertCanNotSeeTableRecords($this->rankGroups->where('status', RankGroupStatus::active));
    });

    test('can filter rank groups by presence of assigned ranks', function () {
        RankItem::factory()->create(['group_id' => $this->rankGroups->first()->id]);

        livewire(RankGroupsList::class)
            ->filterTable('ranks_assigned', true)
            ->assertCanSeeTableRecords(RankGroup::whereHas('ranks')->get())
            ->assertCanNotSeeTableRecords(RankGroup::whereDoesntHave('ranks')->get())
            ->filterTable('ranks_assigned', false)
            ->assertCanSeeTableRecords(RankGroup::whereDoesntHave('ranks')->get())
            ->assertCanNotSeeTableRecords(RankGroup::whereHas('ranks')->get());
    });

    test('can search rank groups by name', function () {
        livewire(RankGroupsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable($this->rankGroups->first()->name)
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with rank create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('has the correct permissions', function () {
        livewire(RankGroupsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->rankGroups->first())
            ->assertTableActionHidden(EditAction::class, $this->rankGroups->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankGroups->first());
    });
});

describe('authorized user with rank delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.delete');
    });

    test('has the correct permissions', function () {
        livewire(RankGroupsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->rankGroups->first())
            ->assertTableActionHidden(EditAction::class, $this->rankGroups->first())
            ->assertTableActionVisible(DeleteAction::class, $this->rankGroups->first());
    });
});

describe('authorized user with rank update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.update');
    });

    test('has the correct permissions', function () {
        livewire(RankGroupsList::class)
            ->assertTableActionHidden(ViewAction::class, $this->rankGroups->first())
            ->assertTableActionVisible(EditAction::class, $this->rankGroups->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankGroups->first());
    });
});

describe('authorized user with rank view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.view');
    });

    test('has the correct permissions', function () {
        livewire(RankGroupsList::class)
            ->assertTableActionVisible(ViewAction::class, $this->rankGroups->first())
            ->assertTableActionHidden(EditAction::class, $this->rankGroups->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankGroups->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage rank groups page', function () {
        get(route('ranks.groups.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage rank groups page', function () {
        get(route('ranks.groups.index'))
            ->assertRedirectToRoute('login');
    });
});
