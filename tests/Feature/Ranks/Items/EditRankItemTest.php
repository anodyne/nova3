<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankItemUpdated;
use Nova\Ranks\Models\RankItem;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('ranks');
uses()->group('rank-items');

beforeEach(function () {
    $this->rankItem = RankItem::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.update');
    });

    test('can view the edit rank item page', function () {
        get(route('admin.ranks.items.edit', $this->rankItem))->assertSuccessful();
    });

    test('can update a rank item', function () {
        Event::fake();

        $data = RankItem::factory()->active()->forRequest();

        from(route('admin.ranks.items.edit', $this->rankItem))
            ->followingRedirects()
            ->put(route('admin.ranks.items.update', $this->rankItem), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankItem::class, $data->model->only('group_id', 'name_id', 'base_image', 'overlay_image', 'status'));

        Event::assertDispatched(RankItemUpdated::class);
    });

    test('can update a rank item to active', function () {
        Event::fake();

        $rankItem = RankItem::factory()->inactive()->create();

        $data = RankItem::factory()->active()->forRequest();

        from(route('admin.ranks.items.edit', $rankItem))
            ->followingRedirects()
            ->put(route('admin.ranks.items.update', $rankItem), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankItem::class, [
            'id' => $rankItem->id,
            'status' => 'active',
        ]);
    });

    test('can update a rank item to inactive', function () {
        Event::fake();

        $rankItem = RankItem::factory()->active()->create();

        $data = RankItem::factory()->inactive()->forRequest();

        from(route('admin.ranks.items.edit', $rankItem))
            ->followingRedirects()
            ->put(route('admin.ranks.items.update', $rankItem), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankItem::class, [
            'id' => $rankItem->id,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit rank item page', function () {
        get(route('admin.ranks.items.edit', $this->rankItem))->assertForbidden();
    });

    test('cannot update a rank item', function () {
        put(route('admin.ranks.items.update', $this->rankItem), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit rank item page', function () {
        get(route('admin.ranks.items.edit', $this->rankItem))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a rank item', function () {
        put(route('admin.ranks.items.update', $this->rankItem), [])
            ->assertRedirectToRoute('login');
    });
});
