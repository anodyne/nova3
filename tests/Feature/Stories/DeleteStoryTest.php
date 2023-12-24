<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryDeleted;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function PHPUnit\Framework\assertCount;

uses()->group('stories');

beforeEach(function () {
    $this->story = Story::factory()
        ->has(Post::factory()->count(5)->published(), 'posts')
        ->create();

    Story::factory()
        ->count(2)
        ->withParent($this->story)
        ->has(Post::factory()->count(5)->published(), 'posts')
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'story.delete');
    });

    test('can view the delete story page', function () {
        get(route('stories.delete', $this->story))
            ->assertSuccessful();
    });

    test('can delete a story and delete its posts', function () {
        Event::fake();

        from(route('stories.delete', $this->story))
            ->followingRedirects()
            ->delete(route('stories.destroy'), [
                'actions' => json_encode([
                    $this->story->id => [
                        'story' => ['action' => 'delete', 'actionId' => null],
                        'posts' => ['action' => 'delete', 'actionId' => null],
                    ],
                ]),
            ])
            ->assertSuccessful();

        assertDatabaseMissing(Story::class, $this->story->toArray());

        assertDatabaseMissing(Post::class, ['story_id' => $this->story->id]);

        Event::assertDispatched(StoryDeleted::class);
    });

    test('can delete a story and move its posts to another story', function () {
        $storyToDelete = $this->story->stories->first();
        $newStory = $this->story;

        from(route('stories.delete', $storyToDelete))
            ->followingRedirects()
            ->delete(route('stories.destroy'), [
                'actions' => json_encode([
                    $storyToDelete->id => [
                        'story' => ['action' => 'delete', 'actionId' => null],
                        'posts' => ['action' => 'move', 'actionId' => $newStory->id],
                    ],
                ]),
            ])
            ->assertSuccessful();

        assertDatabaseMissing(Story::class, $storyToDelete->toArray());

        assertDatabaseMissing(Post::class, ['story_id' => $storyToDelete->id]);

        assertCount(10, $newStory->refresh()->posts);
    });

    test('can delete a story and delete its posts and move a child story to another story', function () {
        $storyToDelete = $this->story;
        $childStory = $this->story->stories->first();

        from(route('stories.delete', $storyToDelete))
            ->followingRedirects()
            ->delete(route('stories.destroy'), [
                'actions' => json_encode([
                    $storyToDelete->id => [
                        'story' => ['action' => 'delete', 'actionId' => null],
                        'posts' => ['action' => 'delete', 'actionId' => null],
                    ],
                    $childStory->id => [
                        'story' => ['action' => 'move', 'actionId' => null],
                        'posts' => ['action' => 'nothing', 'actionId' => null],
                    ],
                ]),
            ])
            ->assertSuccessful();

        assertDatabaseMissing(Story::class, [
            'title' => $storyToDelete->title,
        ]);
        assertDatabaseHas(Story::class, [
            'title' => $childStory->title,
            'parent_id' => null,
        ]);

        assertDatabaseMissing(Post::class, ['story_id' => $storyToDelete->id]);

        assertCount(5, $childStory->refresh()->posts);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the delete story page', function () {
        get(route('stories.delete', $this->story))
            ->assertForbidden();
    });

    test('cannot delete a story', function () {
        delete(route('stories.destroy'), [])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the delete story page', function () {
        get(route('stories.delete', $this->story))
            ->assertRedirectToRoute('login');
    });

    test('cannot delete a story', function () {
        delete(route('stories.destroy'), [])
            ->assertRedirectToRoute('login');
    });
});
