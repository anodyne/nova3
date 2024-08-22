<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\PostTypeCreated;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('stories');
uses()->group('post-types');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'post-type.create');
    });

    test('can view the create post type page', function () {
        get(route('admin.post-types.create'))->assertSuccessful();
    });

    test('can create a post type', function () {
        Event::fake();

        $data = PostType::factory()->make();

        from(route('admin.post-types.create'))
            ->followingRedirects()
            ->post(route('admin.post-types.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(PostType::class, [
            'name' => $data->name,
            'key' => $data->key,
        ]);

        Event::assertDispatched(PostTypeCreated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create post type page', function () {
        get(route('admin.post-types.create'))->assertForbidden();
    });

    test('cannot create a post type', function () {
        post(route('admin.post-types.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create post type page', function () {
        get(route('admin.post-types.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a post type', function () {
        post(route('admin.post-types.store'), [])
            ->assertRedirectToRoute('login');
    });
});
