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
uses()->group('rank-groups');

beforeEach(function () {
    $this->rankGroup = RankGroup::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.update');
    });

    test('can view the edit rank group page', function () {
        get(route('admin.ranks.groups.edit', $this->rankGroup))->assertSuccessful();
    });

    test('can update a rank group', function () {
        Event::fake();

        $data = RankGroup::factory()->inactive()->forRequest();

        from(route('admin.ranks.groups.edit', $this->rankGroup))
            ->followingRedirects()
            ->put(route('admin.ranks.groups.update', $this->rankGroup), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankGroup::class, $data->model->only('name', 'status'));

        Event::assertDispatched(RankGroupUpdated::class);
    });

    test('can update a rank group to active', function () {
        Event::fake();

        $rankGroup = RankGroup::factory()->inactive()->create();

        $data = RankGroup::factory()->active()->forRequest();

        from(route('admin.ranks.groups.edit', $rankGroup))
            ->followingRedirects()
            ->put(route('admin.ranks.groups.update', $rankGroup), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankGroup::class, [
            'id' => $rankGroup->id,
            'status' => 'active',
        ]);
    });

    test('can update a rank group to inactive', function () {
        Event::fake();

        $rankGroup = RankGroup::factory()->active()->create();

        $data = RankGroup::factory()->inactive()->forRequest();

        from(route('admin.ranks.groups.edit', $rankGroup))
            ->followingRedirects()
            ->put(route('admin.ranks.groups.update', $rankGroup), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankGroup::class, [
            'id' => $rankGroup->id,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit rank group page', function () {
        get(route('admin.ranks.groups.edit', $this->rankGroup))->assertForbidden();
    });

    test('cannot update a rank group', function () {
        put(route('admin.ranks.groups.update', $this->rankGroup), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit rank group page', function () {
        get(route('admin.ranks.groups.edit', $this->rankGroup))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a rank group', function () {
        put(route('admin.ranks.groups.update', $this->rankGroup), [])
            ->assertRedirectToRoute('login');
    });
});
