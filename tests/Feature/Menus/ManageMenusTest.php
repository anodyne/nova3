<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Menus\Livewire\MenuItemsList;
use Nova\Menus\Models\MenuItem;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('menus');

beforeEach(function () {
    $this->menuItems = MenuItem::factory()->count(5)->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'menu.create');
    });

    test('can view the list menu items page', function () {
        get(route('menu-items.index'))->assertSuccessful();

        livewire(MenuItemsList::class)
            ->assertCanSeeTableRecords($this->menuItems);
    });

    test('can search menu items by label', function () {
        MenuItem::factory()->create(['label' => 'A test menu item']);

        livewire(MenuItemsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->searchTable('test menu')
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with menu create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'menu.create');
    });

    test('has the correct permissions', function () {
        livewire(MenuItemsList::class)
            ->assertTableActionHidden(EditAction::class, $this->menuItems->first())
            ->assertTableActionHidden(DeleteAction::class, $this->menuItems->first());
    });
});

describe('authorized user with menu delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'menu.delete');
    });

    test('has the correct permissions', function () {
        livewire(MenuItemsList::class)
            ->assertTableActionHidden(EditAction::class, $this->menuItems->first())
            ->assertTableActionVisible(DeleteAction::class, $this->menuItems->first());
    });
});

describe('authorized user with menu update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'menu.update');
    });

    test('has the correct permissions', function () {
        livewire(MenuItemsList::class)
            ->assertTableActionVisible(EditAction::class, $this->menuItems->first())
            ->assertTableActionHidden(DeleteAction::class, $this->menuItems->first());
    });
});

describe('authorized user with menu view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'menu.view');
    });

    test('has the correct permissions', function () {
        livewire(MenuItemsList::class)
            ->assertTableActionHidden(EditAction::class, $this->menuItems->first())
            ->assertTableActionHidden(DeleteAction::class, $this->menuItems->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage menu items page', function () {
        get(route('menu-items.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage menu items page', function () {
        get(route('menu-items.index'))
            ->assertRedirectToRoute('login');
    });
});
