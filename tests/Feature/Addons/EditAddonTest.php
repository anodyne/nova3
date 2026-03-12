<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Addons\Events\AddonUpdated;
use Nova\Addons\Models\Addon;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('addons');

beforeEach(function () {
    $this->addon = Addon::factory()->genre()->active()->create([
        'location' => 'TestGenre',
    ]);
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.update');
    });

    test('can view the edit add-on page', function () {
        get(route('admin.addons.edit', $this->addon))->assertSuccessful();
    });

    test('can update an add-on', function () {
        Event::fake();

        $data = Addon::factory()->genre()->active()->forRequest();

        from(route('admin.addons.edit', $this->addon))
            ->followingRedirects()
            ->put(route('admin.addons.update', $this->addon), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Addon::class, [
            'id' => $this->addon->id,
            'name' => $data->model->name,
            'credits' => $data->model->credits,
            'preview' => $data->model->preview,
        ]);

        Event::assertDispatched(AddonUpdated::class);
    });

    test('can update an add-on to active', function () {
        Event::fake();

        $addon = Addon::factory()->genre()->inactive()->create();

        $data = Addon::factory()->genre()->active()->forRequest();

        from(route('admin.addons.edit', $addon))
            ->followingRedirects()
            ->put(route('admin.addons.update', $addon), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Addon::class, [
            'id' => $addon->id,
            'status' => 'active',
        ]);
    });

    test('can update an add-on to inactive', function () {
        Event::fake();

        $addon = Addon::factory()->genre()->active()->create();

        $data = Addon::factory()->genre()->inactive()->forRequest();

        from(route('admin.addons.edit', $addon))
            ->followingRedirects()
            ->put(route('admin.addons.update', $addon), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Addon::class, [
            'id' => $addon->id,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit add-on page', function () {
        get(route('admin.addons.edit', $this->addon))->assertForbidden();
    });

    test('cannot update an add-on', function () {
        put(route('admin.addons.update', $this->addon), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit add-on page', function () {
        get(route('admin.addons.edit', $this->addon))
            ->assertRedirectToRoute('login');
    });

    test('cannot update an add-on', function () {
        put(route('admin.addons.update', $this->addon), [])
            ->assertRedirectToRoute('login');
    });
});
