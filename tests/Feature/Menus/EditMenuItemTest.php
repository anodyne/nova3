<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Menus\Events\MenuItemUpdated;
use Nova\Menus\Models\MenuItem;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('menus');

beforeEach(function () {
    $this->menuItem = MenuItem::factory()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'menu.update'));

    test('can view the edit menu item page', function () {
        get(route('admin.menu-items.edit', $this->menuItem))->assertSuccessful();
    });

    test('can update a menu item', function () {
        Event::fake();

        $data = MenuItem::factory()->make();

        from(route('admin.menu-items.edit', $this->menuItem))
            ->followingRedirects()
            ->put(route('admin.menu-items.update', $this->menuItem), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(MenuItem::class, $data->toArray());

        Event::assertDispatched(MenuItemUpdated::class);
    });

    test('can update a menu item status from inactive to active', function () {
        $menuItem = MenuItem::factory()->inactive()->create();

        $data = MenuItem::factory()->active()->forRequest();

        from(route('admin.menu-items.edit', $menuItem))
            ->followingRedirects()
            ->put(route('admin.menu-items.update', $menuItem), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(MenuItem::class, [
            'id' => $menuItem->id,
            'status' => 'active',
        ]);
    });

    test('can update a menu item status from active to inactive', function () {
        $menuItem = MenuItem::factory()->active()->create();

        $data = MenuItem::factory()->inactive()->forRequest();

        from(route('admin.menu-items.edit', $menuItem))
            ->followingRedirects()
            ->put(route('admin.menu-items.update', $menuItem), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(MenuItem::class, [
            'id' => $menuItem->id,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the edit menu item page', function () {
        get(route('admin.menu-items.edit', $this->menuItem))
            ->assertForbidden();
    });

    test('cannot update a menu item', function () {
        $data = MenuItem::factory()->make();

        put(route('admin.menu-items.update', $this->menuItem), $data->toArray())
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit menu item page', function () {
        get(route('admin.menu-items.edit', $this->menuItem))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a menu item', function () {
        put(route('admin.menu-items.update', $this->menuItem), [])
            ->assertRedirectToRoute('login');
    });
});
