<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameCreated;
use Nova\Ranks\Models\RankName;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('ranks');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the create rank name page', function () {
        get(route('ranks.names.create'))->assertSuccessful();
    });

    test('can create a rank name', function () {
        Event::fake();

        $data = RankName::factory()->make();

        from(route('ranks.names.create'))
            ->followingRedirects()
            ->post(route('ranks.names.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(RankName::class, $data->toArray());

        Event::assertDispatched(RankNameCreated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create rank name page', function () {
        get(route('ranks.names.create'))->assertForbidden();
    });

    test('cannot create a rank name', function () {
        post(route('ranks.names.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create rank name page', function () {
        get(route('ranks.names.create'))
            ->assertRedirect(route('login'));
    });

    test('cannot create a rank name', function () {
        post(route('ranks.names.store'), [])
            ->assertRedirect(route('login'));
    });
});
