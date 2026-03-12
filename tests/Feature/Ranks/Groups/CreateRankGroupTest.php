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
uses()->group('rank-groups');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the create rank group page', function () {
        get(route('admin.ranks.groups.create'))->assertSuccessful();
    });

    test('can create a rank group', function () {
        Event::fake();

        $data = RankGroup::factory()->active()->forRequest();

        from(route('admin.ranks.groups.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.groups.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankGroup::class, $data->model->only('name', 'status'));

        Event::assertDispatched(RankGroupCreated::class);
    });

    test('can create an active rank group', function () {
        Event::fake();

        $data = RankGroup::factory()->active()->forRequest();

        from(route('admin.ranks.groups.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.groups.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankGroup::class, [
            'name' => $data->model->name,
            'status' => 'active',
        ]);
    });

    test('can create an inactive rank group', function () {
        Event::fake();

        $data = RankGroup::factory()->inactive()->forRequest();

        from(route('admin.ranks.groups.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.groups.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankGroup::class, [
            'name' => $data->model->name,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create rank group page', function () {
        get(route('admin.ranks.groups.create'))->assertForbidden();
    });

    test('cannot create a rank group', function () {
        post(route('admin.ranks.groups.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create rank group page', function () {
        get(route('admin.ranks.groups.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a rank group', function () {
        post(route('admin.ranks.groups.store'), [])
            ->assertRedirectToRoute('login');
    });
});
