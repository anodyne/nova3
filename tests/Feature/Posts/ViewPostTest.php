<?php

declare(strict_types=1);

use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

use function Pest\Laravel\get;

uses()->group('posts', 'storytelling');

beforeEach(function () {
    $this->story = Story::factory()->current()->create();
    $this->post = Post::factory()->published()->withStory($this->story)->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'post.view'));

    test('can view the view post page', function () {
        get(route('admin.posts.show', [$this->story, $this->post]))->assertSuccessful();
    });

    test('view post page includes loaded post, story, and published sibling context', function (): void {
        $previousPublishedPost = Post::factory()->published()->withStory($this->story)->create();
        $currentPost = Post::factory()->published()->withStory($this->story)->create();
        $nextPublishedPost = Post::factory()->published()->withStory($this->story)->create();

        Post::factory()->draft()->withStory($this->story)->create();

        get(route('admin.posts.show', [$this->story, $currentPost]))
            ->assertSuccessful()
            ->assertViewHas('post', function (Post $post) use ($currentPost): bool {
                return $post->is($currentPost)
                    && $post->relationLoaded('characterAuthors')
                    && $post->relationLoaded('userAuthors');
            })
            ->assertViewHas('story', fn (Story $story): bool => $story->is($this->story))
            ->assertViewHas('previousPost', fn (?Post $post): bool => $post?->is($previousPublishedPost) ?? false)
            ->assertViewHas('nextPost', fn (?Post $post): bool => $post?->is($nextPublishedPost) ?? false);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the view post page', function () {
        get(route('admin.posts.show', [$this->story, $this->post]))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view post page', function () {
        get(route('admin.posts.show', [$this->story, $this->post]))
            ->assertRedirectToRoute('login');
    });
});
