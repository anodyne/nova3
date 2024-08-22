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

        $data = RankName::factory()->make();

        from(route('admin.ranks.names.edit', $this->rankName))
            ->followingRedirects()
            ->put(route('admin.ranks.names.update', $this->rankName), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(RankName::class, $data->toArray());

        Event::assertDispatched(RankNameUpdated::class);
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
