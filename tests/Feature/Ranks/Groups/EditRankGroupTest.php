<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankGroupUpdated;
use Nova\Ranks\Models\RankGroup;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('ranks');

beforeEach(function () {
    $this->rankGroup = RankGroup::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.update');
    });

    test('can view the edit rank group page', function () {
        get(route('ranks.groups.edit', $this->rankGroup))->assertSuccessful();
    });

    test('can update a rank group', function () {
        Event::fake();

        $data = RankGroup::factory()->make();

        from(route('ranks.groups.edit', $this->rankGroup))
            ->followingRedirects()
            ->put(route('ranks.groups.update', $this->rankGroup), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(RankGroup::class, $data->toArray());

        Event::assertDispatched(RankGroupUpdated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit rank group page', function () {
        get(route('ranks.groups.edit', $this->rankGroup))->assertForbidden();
    });

    test('cannot update a rank group', function () {
        put(route('ranks.groups.update', $this->rankGroup), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit rank group page', function () {
        get(route('ranks.groups.edit', $this->rankGroup))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a rank group', function () {
        put(route('ranks.groups.update', $this->rankGroup), [])
            ->assertRedirectToRoute('login');
    });
});
