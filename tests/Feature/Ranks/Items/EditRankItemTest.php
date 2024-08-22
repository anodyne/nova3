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

        $data = RankItem::factory()->make();

        from(route('admin.ranks.items.edit', $this->rankItem))
            ->followingRedirects()
            ->put(route('admin.ranks.items.update', $this->rankItem), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(RankItem::class, $data->toArray());

        Event::assertDispatched(RankItemUpdated::class);
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
