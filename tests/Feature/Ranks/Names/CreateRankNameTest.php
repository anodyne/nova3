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
uses()->group('rank-names');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.create');
    });

    test('can view the create rank name page', function () {
        get(route('admin.ranks.names.create'))->assertSuccessful();
    });

    test('can create a rank name', function () {
        Event::fake();

        $data = RankName::factory()->active()->forRequest();

        from(route('admin.ranks.names.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.names.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankName::class, $data->model->only('name', 'status'));

        Event::assertDispatched(RankNameCreated::class);
    });

    test('can create an active rank name', function () {
        Event::fake();

        $data = RankName::factory()->active()->forRequest();

        from(route('admin.ranks.names.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.names.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankName::class, [
            'name' => $data->model->name,
            'status' => 'active',
        ]);
    });

    test('can create an inactive rank name', function () {
        Event::fake();

        $data = RankName::factory()->inactive()->forRequest();

        from(route('admin.ranks.names.create'))
            ->followingRedirects()
            ->post(route('admin.ranks.names.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(RankName::class, [
            'name' => $data->model->name,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create rank name page', function () {
        get(route('admin.ranks.names.create'))->assertForbidden();
    });

    test('cannot create a rank name', function () {
        post(route('admin.ranks.names.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create rank name page', function () {
        get(route('admin.ranks.names.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a rank name', function () {
        post(route('admin.ranks.names.store'), [])
            ->assertRedirectToRoute('login');
    });
});
