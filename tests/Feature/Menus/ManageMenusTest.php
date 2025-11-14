<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
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
    beforeEach(fn () => signIn(permissions: 'menu.create'));

    test('can view the list menu items page', function () {
        get(route('admin.menu-items.index'))->assertSuccessful();

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
    beforeEach(fn () => signIn(permissions: 'menu.create'));

    test('has the correct permissions', function () {
        $menuItem = $this->menuItems->first();

        livewire(MenuItemsList::class)
            ->assertActionHidden(TestAction::make(EditAction::class)->table($menuItem))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($menuItem));
    });
});

describe('authorized user with menu delete permissions', function () {
    beforeEach(fn () => signIn(permissions: 'menu.delete'));

    test('has the correct permissions', function () {
        $menuItem = $this->menuItems->first();

        livewire(MenuItemsList::class)
            ->assertActionHidden(TestAction::make(EditAction::class)->table($menuItem))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($menuItem));
    });
});

describe('authorized user with menu update permissions', function () {
    beforeEach(fn () => signIn(permissions: 'menu.update'));

    test('has the correct permissions', function () {
        $menuItem = $this->menuItems->first();

        livewire(MenuItemsList::class)
            ->assertActionVisible(TestAction::make(EditAction::class)->table($menuItem))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($menuItem));
    });
});

describe('authorized user with menu view permissions', function () {
    beforeEach(fn () => signIn(permissions: 'menu.view'));

    test('has the correct permissions', function () {
        $menuItem = $this->menuItems->first();

        livewire(MenuItemsList::class)
            ->assertActionHidden(TestAction::make(EditAction::class)->table($menuItem))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($menuItem));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the manage menu items page', function () {
        get(route('admin.menu-items.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage menu items page', function () {
        get(route('admin.menu-items.index'))
            ->assertRedirectToRoute('login');
    });
});
