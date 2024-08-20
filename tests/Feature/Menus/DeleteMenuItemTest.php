<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Menus\Events\MenuItemDeleted;
use Nova\Menus\Livewire\MenuItemsList;
use Nova\Menus\Models\MenuItem;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('menus');

beforeEach(function () {
    $this->menuItems = MenuItem::factory()->count(10)->create();

    signIn(permissions: 'menu.delete');
});

test('an authorized user can delete a menu item', function () {
    Event::fake();

    $menuItem = $this->menuItems->first();

    livewire(MenuItemsList::class)
        ->callTableAction(DeleteAction::class, $menuItem)
        ->assertCanNotSeeTableRecords([$menuItem])
        ->assertNotified();

    assertDatabaseMissing(MenuItem::class, $menuItem->only('id', 'label'));

    Event::assertDispatched(MenuItemDeleted::class);
});

test('nested menu items are deleted when the parent is deleted', function () {
    $menuItem = $this->menuItems->first();

    $nestedMenuItems = MenuItem::factory()->count(2)->create([
        'parent_id' => $menuItem->id,
    ]);

    livewire(MenuItemsList::class)
        ->callTableAction(DeleteAction::class, $menuItem)
        ->assertCanNotSeeTableRecords([$menuItem, ...$nestedMenuItems])
        ->assertNotified();

    assertDatabaseMissing(MenuItem::class, $menuItem->only('id', 'label'));
    assertDatabaseMissing(MenuItem::class, $nestedMenuItems[0]->only('id', 'label'));
    assertDatabaseMissing(MenuItem::class, $nestedMenuItems[1]->only('id', 'label'));
});

test('an authorized user can bulk delete menu items', function () {
    $menuItems = $this->menuItems->take(3);

    livewire(MenuItemsList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $menuItems)
        ->assertNotified();

    foreach ($menuItems as $menuItem) {
        assertDatabaseMissing(MenuItem::class, $menuItem->toArray());
    }
});
