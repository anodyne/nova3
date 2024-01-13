<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Ranks\Enums\RankNameStatus;
use Nova\Ranks\Livewire\RankNamesList;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('ranks');

beforeEach(function () {
    $this->rankNames = RankName::factory()
        ->count(10)
        ->sequence(
            ['status' => RankNameStatus::active],
            ['status' => RankNameStatus::inactive],
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the list rank names page', function () {
        get(route('ranks.names.index'))->assertSuccessful();

        livewire(RankNamesList::class)
            ->assertCanSeeTableRecords($this->rankNames);
    });

    test('can filter rank names by status', function () {
        livewire(RankNamesList::class)
            ->filterTable('status', RankNameStatus::active->value)
            ->assertCanSeeTableRecords($this->rankNames->where('status', RankNameStatus::active))
            ->assertCanNotSeeTableRecords($this->rankNames->where('status', RankNameStatus::inactive))
            ->filterTable('status', RankNameStatus::inactive->value)
            ->assertCanSeeTableRecords($this->rankNames->where('status', RankNameStatus::inactive))
            ->assertCanNotSeeTableRecords($this->rankNames->where('status', RankNameStatus::active));
    });

    test('can filter rank names by presence of assigned ranks', function () {
        RankItem::factory()->create(['name_id' => $this->rankNames->first()->id]);

        livewire(RankNamesList::class)
            ->filterTable('ranks_assigned', true)
            ->assertCanSeeTableRecords(RankName::whereHas('ranks')->get())
            ->assertCanNotSeeTableRecords(RankName::whereDoesntHave('ranks')->get())
            ->filterTable('ranks_assigned', false)
            ->assertCanSeeTableRecords(RankName::whereDoesntHave('ranks')->get())
            ->assertCanNotSeeTableRecords(RankName::whereHas('ranks')->get());
    });

    test('can search rank names by name', function () {
        livewire(RankNamesList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->searchTable($this->rankNames->first()->name)
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with rank create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('has the correct permissions', function () {
        livewire(RankNamesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->rankNames->first())
            ->assertTableActionHidden(EditAction::class, $this->rankNames->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankNames->first());
    });
});

describe('authorized user with rank delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.delete');
    });

    test('has the correct permissions', function () {
        livewire(RankNamesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->rankNames->first())
            ->assertTableActionHidden(EditAction::class, $this->rankNames->first())
            ->assertTableActionVisible(DeleteAction::class, $this->rankNames->first());
    });
});

describe('authorized user with rank update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.update');
    });

    test('has the correct permissions', function () {
        livewire(RankNamesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->rankNames->first())
            ->assertTableActionVisible(EditAction::class, $this->rankNames->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankNames->first());
    });
});

describe('authorized user with rank view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.view');
    });

    test('has the correct permissions', function () {
        livewire(RankNamesList::class)
            ->assertTableActionVisible(ViewAction::class, $this->rankNames->first())
            ->assertTableActionHidden(EditAction::class, $this->rankNames->first())
            ->assertTableActionHidden(DeleteAction::class, $this->rankNames->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage rank names page', function () {
        get(route('ranks.names.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage rank names page', function () {
        get(route('ranks.names.index'))
            ->assertRedirectToRoute('login');
    });
});
