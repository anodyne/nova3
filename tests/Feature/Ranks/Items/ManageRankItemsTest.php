<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Ranks\Enums\RankItemStatus;
use Nova\Ranks\Livewire\RankItemsList;
use Nova\Ranks\Models\RankItem;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('ranks');

beforeEach(function () {
    $this->rankItems = RankItem::factory()
        ->count(10)
        ->sequence(
            ['status' => RankItemStatus::active],
            ['status' => RankItemStatus::inactive],
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the list rank items page', function () {
        get(route('ranks.items.index'))->assertSuccessful();

        livewire(RankItemsList::class)
            ->assertCanSeeTableRecords($this->rankItems);
    });

    test('can filter rank items by status', function () {
        livewire(RankItemsList::class)
            ->filterTable('status', RankItemStatus::active->value)
            ->assertCanSeeTableRecords($this->rankItems->where('status', RankItemStatus::active))
            ->assertCanNotSeeTableRecords($this->rankItems->where('status', RankItemStatus::inactive))
            ->filterTable('status', RankItemStatus::inactive->value)
            ->assertCanSeeTableRecords($this->rankItems->where('status', RankItemStatus::inactive))
            ->assertCanNotSeeTableRecords($this->rankItems->where('status', RankItemStatus::active));
    });

    test('can filter rank items by group', function () {
        $rankGroupId = $this->rankItems->first()->group_id;

        livewire(RankItemsList::class)
            ->filterTable('group_id', $rankGroupId)
            ->assertCanSeeTableRecords($this->rankItems->where('group_id', $rankGroupId))
            ->assertCanNotSeeTableRecords($this->rankItems->where('group_id', '!=', $rankGroupId));
    });

    test('can filter rank items by name', function () {
        $rankNameId = $this->rankItems->first()->name_id;

        livewire(RankItemsList::class)
            ->filterTable('name_id', $rankNameId)
            ->assertCanSeeTableRecords($this->rankItems->where('name_id', $rankNameId))
            ->assertCanNotSeeTableRecords($this->rankItems->where('name_id', '!=', $rankNameId));
    });

    test('can search rank items by name', function () {
        livewire(RankItemsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable($this->rankItems->first()->name->name)
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with rank create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('has the correct permissions', function () {
        livewire(RankItemsList::class)
            ->assertTableHeaderActionsExistInOrder([
                CreateAction::class,
            ])
            ->assertTableActionHidden(ViewAction::class, $this->rankItems->first())
            ->assertTableActionHidden(EditAction::class, $this->rankItems->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankItems->first());
    });
});

describe('authorized user with rank delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.delete');
    });

    test('has the correct permissions', function () {
        livewire(RankItemsList::class)
            ->assertTableHeaderActionsExistInOrder([])
            ->assertTableActionHidden(ViewAction::class, $this->rankItems->first())
            ->assertTableActionHidden(EditAction::class, $this->rankItems->first())
            ->assertTableActionVisible(DeleteAction::class, $this->rankItems->first());
    });
});

describe('authorized user with rank update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.update');
    });

    test('has the correct permissions', function () {
        livewire(RankItemsList::class)
            ->assertTableHeaderActionsExistInOrder([])
            ->assertTableActionHidden(ViewAction::class, $this->rankItems->first())
            ->assertTableActionVisible(EditAction::class, $this->rankItems->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankItems->first());
    });
});

describe('authorized user with rank view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.view');
    });

    test('has the correct permissions', function () {
        livewire(RankItemsList::class)
            ->assertTableHeaderActionsExistInOrder([])
            ->assertTableActionVisible(ViewAction::class, $this->rankItems->first())
            ->assertTableActionHidden(EditAction::class, $this->rankItems->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankItems->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage rank items page', function () {
        get(route('ranks.items.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage rank items page', function () {
        get(route('ranks.items.index'))
            ->assertRedirectToRoute('login');
    });
});
