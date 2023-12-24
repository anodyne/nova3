<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\PostTypeUpdated;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('stories');
uses()->group('post-types');

beforeEach(function () {
    $this->postType = PostType::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'post-type.update');
    });

    test('can view the edit post type page', function () {
        get(route('post-types.edit', $this->postType))->assertSuccessful();
    });

    test('can update a post type', function () {
        Event::fake();

        $data = PostType::factory()->make();

        from(route('post-types.edit', $this->postType))
            ->followingRedirects()
            ->put(route('post-types.update', $this->postType), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(PostType::class, [
            'name' => $data->name,
            'key' => $data->key,
        ]);

        Event::assertDispatched(PostTypeUpdated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit post type page', function () {
        get(route('post-types.edit', $this->postType))->assertForbidden();
    });

    test('cannot update a post type', function () {
        put(route('post-types.update', $this->postType), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit post type page', function () {
        get(route('post-types.edit', $this->postType))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a post type', function () {
        put(route('post-types.update', $this->postType), [])
            ->assertRedirectToRoute('login');
    });
});
