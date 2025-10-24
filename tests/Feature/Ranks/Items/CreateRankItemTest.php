<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankItemCreated;
use Nova\Ranks\Models\RankItem;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('ranks');
uses()->group('rank-items');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the create rank item page', function () {
        get(route('admin.ranks.items.create'))->assertSuccessful();
    });

    test('can create a rank item', function () {
        Event::fake();

        $data = RankItem::factory()->active()->forRequest();

        from(route('admin.ranks.items.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.items.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankItem::class, $data->model->only('group_id', 'name_id', 'base_image', 'overlay_image', 'status'));

        Event::assertDispatched(RankItemCreated::class);
    });

    test('can create an active rank item', function () {
        Event::fake();

        $data = RankItem::factory()->active()->forRequest();

        from(route('admin.ranks.items.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.items.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankItem::class, [
            'group_id' => $data->model->group_id,
            'name_id' => $data->model->name_id,
            'base_image' => $data->model->base_image,
            'overlay_image' => $data->model->overlay_image,
            'status' => 'active',
        ]);
    });

    test('can create an inactive rank item', function () {
        Event::fake();

        $data = RankItem::factory()->inactive()->forRequest();

        from(route('admin.ranks.items.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.items.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankItem::class, [
            'group_id' => $data->model->group_id,
            'name_id' => $data->model->name_id,
            'base_image' => $data->model->base_image,
            'overlay_image' => $data->model->overlay_image,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create rank item page', function () {
        get(route('admin.ranks.items.create'))->assertForbidden();
    });

    test('cannot create a rank item', function () {
        post(route('admin.ranks.items.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create rank item page', function () {
        get(route('admin.ranks.items.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a rank item', function () {
        post(route('admin.ranks.items.store'), [])
            ->assertRedirectToRoute('login');
    });
});
