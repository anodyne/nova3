<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Nova\Stories\Livewire\PostsList;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Pending;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'post.create'));

    test('can view the list posts page', function () {
        Post::factory(5)->published()->create();

        get(route('admin.posts.index'))
            ->assertSuccessful();

        livewire(PostsList::class)
            ->assertCountTableRecords(5);
    });

    test('can filter posts by status', function () {
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

    test('can filter posts by post type', function () {
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

    test('can filter posts by story', function () {
        $story = Story::factory()->current()->create();

        Post::factory(2)->published()->withStory($story)->create();

        Post::factory(2)->published()->create();

        livewire(PostsList::class)
            ->filterTable('story', [$story->id])
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords(Post::query()->story($story)->get())
            ->assertCanNotSeeTableRecords(Post::where('story_id', '!=', $story->id)->get());
    });

    test('can filter posts by published state', function () {
        Post::factory(2)->published()->create();
        Post::factory(2)->draft()->create();

        livewire(PostsList::class)
            ->filterTable('published', true)
            ->assertCountTableRecords(2);
    });

    test('can search posts by title', function () {
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

    test('can unlock a locked post', function () {
        signIn(permissions: 'post.update');

        $post = Post::factory()->draft()->create();
        $post->lock(Auth::user());

        livewire(PostsList::class)
            ->callAction(TestAction::make('unlock')->table($post))
            ->assertNotified();

        assertDatabaseHas(Post::class, [
            'id' => $post->id,
            'locked_at' => null,
            'locked_by' => null,
        ]);
    });
});

describe('unauthorized user', function () {
    test('cannot view the manage posts page', function () {
        signIn();

        get(route('admin.posts.index'))->assertForbidden();
    });

    test('cannot unlock a locked post', function () {
        $post = Post::factory()->draft()->create();
        $post->lock($post->participatingUsers->first());

        signIn(permissions: 'post.create');

        livewire(PostsList::class)
            ->assertActionHidden(TestAction::make('unlock')->table($post));

        assertDatabaseMissing(Post::class, [
            'id' => $post->id,
            'locked_at' => null,
            'locked_by' => null,
        ]);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage posts page', function () {
        get(route('admin.posts.index'))
            ->assertRedirectToRoute('login');
    });
});
