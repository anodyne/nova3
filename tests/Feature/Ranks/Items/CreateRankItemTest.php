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

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the create rank item page', function () {
        get(route('admin.ranks.items.create'))->assertSuccessful();
    });

    test('can create a rank item', function () {
        Event::fake();

        $data = RankItem::factory()->make();

        from(route('admin.ranks.items.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.items.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(RankItem::class, $data->toArray());

        Event::assertDispatched(RankItemCreated::class);
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
