<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Livewire\AddonsList;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('addons');

beforeEach(function () {
    $this->addons = Addon::factory()
        ->count(10)
        ->sequence(
            ['status' => BasicStatus::Active],
            ['status' => BasicStatus::Inactive],
        )
        ->active()
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.create');
    });

    test('can view the list add-ons page', function () {
        get(route('admin.addons.index'))->assertSuccessful();

        livewire(AddonsList::class)
            ->assertCanSeeTableRecords($this->addons);
    });

    test('can filter add-ons by type', function () {
        livewire(AddonsList::class)
            ->filterTable('type', AddonType::Genre->value)
            ->assertCanSeeTableRecords($this->addons->where('type', AddonType::Genre))
            ->assertCanNotSeeTableRecords($this->addons->where('type', '!=', AddonType::Genre))
            ->filterTable('type', AddonType::Extension->value)
            ->assertCanSeeTableRecords($this->addons->where('type', AddonType::Extension))
            ->assertCanNotSeeTableRecords($this->addons->where('type', '!=', AddonType::Extension))
            ->filterTable('type', AddonType::Rank->value)
            ->assertCanSeeTableRecords($this->addons->where('type', AddonType::Rank))
            ->assertCanNotSeeTableRecords($this->addons->where('type', '!=', AddonType::Rank));
    });

    test('can filter add-ons by status', function () {
        livewire(AddonsList::class)
            ->filterTable('status', BasicStatus::Active->value)
            ->assertCanSeeTableRecords($this->addons->where('status', BasicStatus::Active))
            ->assertCanNotSeeTableRecords($this->addons->where('status', '!=', BasicStatus::Active))
            ->filterTable('status', BasicStatus::Inactive->value)
            ->assertCanSeeTableRecords($this->addons->where('status', BasicStatus::Inactive))
            ->assertCanNotSeeTableRecords($this->addons->where('status', '!=', BasicStatus::Inactive));
    });

    test('can search add-ons by name', function () {
        livewire(AddonsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable($this->addons->first()->name)
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with add-on create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.create');
    });

    test('has the correct permissions', function () {
        livewire(AddonsList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($this->addons->first()))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($this->addons->first()))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->addons->first()));
    });
});

describe('authorized user with add-on delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.delete');
    });

    test('has the correct permissions', function () {
        livewire(AddonsList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($this->addons->first()))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($this->addons->first()))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($this->addons->first()));
    });
});

describe('authorized user with add-on update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.update');
    });

    test('has the correct permissions', function () {
        livewire(AddonsList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($this->addons->first()))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($this->addons->first()))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->addons->first()));
    });
});

describe('authorized user with add-on view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.view');
    });

    test('has the correct permissions', function () {
        livewire(AddonsList::class)
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($this->addons->first()))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($this->addons->first()))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->addons->first()));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage add-ons page', function () {
        get(route('admin.addons.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage add-ons page', function () {
        get(route('admin.addons.index'))
            ->assertRedirectToRoute('login');
    });
});
