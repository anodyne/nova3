<?php

declare(strict_types=1);

use Nova\Stories\Livewire\PostSetup;
use Nova\Stories\Models\Post;

use function Pest\Laravel\get;

uses()->group('posts', 'storytelling');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'post.create'));

    test('can view the create post page', function () {
        get(route('admin.posts.create'))
            ->assertSuccessful()
            ->assertSeeLivewire(PostSetup::class);
    });

    test('create post page defaults to after direction', function () {
        get(route('admin.posts.create'))
            ->assertSuccessful()
            ->assertViewHas('post', fn (Post $post): bool => $post->neighbor === null && $post->direction === 'after');
    });

    test('can view create post page with a neighbor and direction', function () {
        $neighbor = Post::factory()->published()->create();

        get(route('admin.posts.create', ['neighbor' => $neighbor, 'direction' => 'before']))
            ->assertSuccessful()
            ->assertViewHas(
                'post',
                fn (Post $post): bool => (string) $post->neighbor === (string) $neighbor->getRouteKey() && $post->direction === 'before'
            );
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the create post page', function () {
        get(route('admin.posts.create'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create post page', function () {
        get(route('admin.posts.create'))
            ->assertRedirectToRoute('login');
    });
});
