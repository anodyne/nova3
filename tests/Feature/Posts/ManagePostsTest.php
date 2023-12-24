<?php

declare(strict_types=1);

use Nova\Stories\Livewire\PostsList;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Pending;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('stories');
uses()->group('posts');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'post.create');
    });

    it('can view the list posts page', function () {
        Post::factory(5)->published()->create();

        get(route('posts.index'))->assertSuccessful();

        livewire(PostsList::class)
            ->assertCountTableRecords(5);
    });

    it('can filter posts by status', function () {
        $posts = Post::factory(6)
            ->sequence(
                ['status' => 'draft'],
                ['status' => 'pending'],
                ['status' => 'published'],
            )
            ->create();

        livewire(PostsList::class)
            ->filterTable('status', Draft::$name)
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords($posts->where('status', Draft::$name))
            ->assertCanNotSeeTableRecords($posts->where('status', '!=', Draft::$name))
            ->resetTableFilters()
            ->filterTable('status', Published::$name)
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords($posts->where('status', Published::$name))
            ->assertCanNotSeeTableRecords($posts->where('status', '!=', Published::$name))
            ->resetTableFilters()
            ->filterTable('status', Pending::$name)
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords($posts->where('status', Pending::$name))
            ->assertCanNotSeeTableRecords($posts->where('status', '!=', Pending::$name));
    });

    it('can filter posts by post type', function () {
        Post::factory(2)->storyPost()->published()->create();
        Post::factory(2)->personalPost()->published()->create();
        Post::factory(2)->markerPost()->published()->create();
        Post::factory(2)->notePost()->published()->create();

        livewire(PostsList::class)
            ->filterTable('postType', [1])
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords(Post::where('post_type_id', 1)->get())
            ->assertCanNotSeeTableRecords(Post::where('post_type_id', '!=', 1)->get());
    });

    it('can filter posts by story', function () {
        $story = Story::factory()->current()->create();

        Post::factory(2)->published()->withStory($story)->create();

        Post::factory(2)->published()->create();

        livewire(PostsList::class)
            ->filterTable('story', [$story->id])
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords(Post::query()->story($story)->get())
            ->assertCanNotSeeTableRecords(Post::where('story_id', '!=', $story->id)->get());
    });

    it('can filter posts by published state', function () {
        Post::factory(2)->published()->create();
        Post::factory(2)->create();

        livewire(PostsList::class)
            ->filterTable('published', true)
            ->assertCountTableRecords(2);
    });

    it('can search posts by title', function () {
        Post::factory(2)
            ->sequence(
                ['title' => 'My post'],
                ['title' => 'Something else'],
            )
            ->create();

        livewire(PostsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable('My post')
            ->assertCountTableRecords(1);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    it('cannot view the manage posts page', function () {
        get(route('posts.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage posts page', function () {
        get(route('posts.index'))
            ->assertRedirectToRoute('login');
    });
});
