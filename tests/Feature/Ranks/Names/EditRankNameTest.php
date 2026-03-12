<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameUpdated;
use Nova\Ranks\Models\RankName;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('ranks');
uses()->group('rank-names');

beforeEach(function () {
    $this->rankName = RankName::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.update');
    });

    test('can view the edit rank name page', function () {
        get(route('admin.ranks.names.edit', $this->rankName))->assertSuccessful();
    });

    test('can update a rank name', function () {
        Event::fake();

        $data = RankName::factory()->inactive()->forRequest();

        from(route('admin.ranks.names.edit', $this->rankName))
            ->followingRedirects()
            ->put(route('admin.ranks.names.update', $this->rankName), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankName::class, $data->model->only('name', 'status'));

        Event::assertDispatched(RankNameUpdated::class);
    });

    test('can update a rank name to active', function () {
        Event::fake();

        $rankName = RankName::factory()->inactive()->create();

        $data = RankName::factory()->active()->forRequest();

        from(route('admin.ranks.names.edit', $rankName))
            ->followingRedirects()
            ->put(route('admin.ranks.names.update', $rankName), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankName::class, [
            'id' => $rankName->id,
            'status' => 'active',
        ]);
    });

    test('can update a rank name to inactive', function () {
        Event::fake();

        $rankName = RankName::factory()->active()->create();

        $data = RankName::factory()->inactive()->forRequest();

        from(route('admin.ranks.names.edit', $rankName))
            ->followingRedirects()
            ->put(route('admin.ranks.names.update', $rankName), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankName::class, [
            'id' => $rankName->id,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit rank name page', function () {
        get(route('admin.ranks.names.edit', $this->rankName))->assertForbidden();
    });

    test('cannot update a rank name', function () {
        put(route('admin.ranks.names.update', $this->rankName), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit rank name page', function () {
        get(route('admin.ranks.names.edit', $this->rankName))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a rank name', function () {
        put(route('admin.ranks.names.update', $this->rankName), [])
            ->assertRedirectToRoute('login');
    });
});
