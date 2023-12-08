<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupCreated;
use Nova\Ranks\Models\RankGroup;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('ranks');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the create rank group page', function () {
        get(route('ranks.groups.create'))->assertSuccessful();
    });

    test('can create a rank group', function () {
        Event::fake();

        $data = RankGroup::factory()->make();

        from(route('ranks.groups.create'))
            ->followingRedirects()
            ->post(route('ranks.groups.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(RankGroup::class, $data->toArray());

        Event::assertDispatched(RankGroupCreated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create rank group page', function () {
        get(route('ranks.groups.create'))->assertForbidden();
    });

    test('cannot create a rank group', function () {
        post(route('ranks.groups.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create rank group page', function () {
        get(route('ranks.groups.create'))
            ->assertRedirect(route('login'));
    });

    test('cannot create a rank group', function () {
        post(route('ranks.groups.store'), [])
            ->assertRedirect(route('login'));
    });
});
