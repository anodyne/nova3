<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Menus\Events\MenuItemCreated;
use Nova\Menus\Models\MenuItem;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('menus');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'menu.create');
    });

    test('can view the create menu item page', function () {
        get(route('admin.menu-items.create'))->assertSuccessful();
    });

    test('can create a menu item', function () {
        Event::fake();

        $data = MenuItem::factory()->make();

        from(route('admin.menu-items.create'))
            ->followingRedirects()
            ->post(route('admin.menu-items.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(MenuItem::class, $data->toArray());

        Event::assertDispatched(MenuItemCreated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create menu item page', function () {
        get(route('admin.menu-items.create'))->assertForbidden();
    });

    test('cannot create a menu item', function () {
        $data = MenuItem::factory()->make();

        post(route('admin.menu-items.store'), $data->toArray())->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create menu item page', function () {
        get(route('admin.menu-items.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a menu item', function () {
        post(route('admin.menu-items.store'), [])
            ->assertRedirectToRoute('login');
    });
});
