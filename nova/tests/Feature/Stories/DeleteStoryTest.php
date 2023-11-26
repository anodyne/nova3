<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryDeleted;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

beforeEach(function () {
    $this->story = Story::factory()->create();
});
test('authorized user can view the delete stories page', function () {
    $this->signInWithPermission('story.delete');

    $response = $this->get(route('stories.delete', $this->story));
    $response->assertSuccessful();
});
test('authorized user can delete story', function () {
    $this->signInWithPermission('story.delete');

    $this->followingRedirects();

    $response = $this->delete(route('stories.destroy'), [
        'actions' => json_encode([
            $this->story->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
        ]),
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseMissing('stories', [
        'id' => $this->story->id,
    ]);
});
test('event is dispatched when story is deleted', function () {
    Event::fake();

    $this->signInWithPermission('story.delete');

    $this->delete(route('stories.destroy'), [
        'actions' => json_encode([
            $this->story->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
        ]),
    ]);

    Event::assertDispatched(StoryDeleted::class);
});
test('nested stories can be deleted when deleting the parent story', function () {
    $nestedStory = Story::factory()->withParent($this->story)->create();

    $this->signInWithPermission('story.delete');

    $this->followingRedirects();

    $response = $this->delete(route('stories.destroy'), [
        'actions' => json_encode([
            $this->story->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
            $nestedStory->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
        ]),
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseMissing('stories', [
        'id' => $this->story->id,
    ]);

    $this->assertDatabaseMissing('stories', [
        'id' => $nestedStory->id,
    ]);
});
test('nested stories can be moved when deleting the parent story', function () {
    $nestedStory = Story::factory()->withParent($this->story)->create();

    $this->signInWithPermission('story.delete');

    $this->followingRedirects();

    $response = $this->delete(route('stories.destroy'), [
        'actions' => json_encode([
            $this->story->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
            $nestedStory->id => [
                'story' => ['action' => 'move', 'actionId' => null],
                'posts' => ['action' => 'nothing', 'actionId' => null],
            ],
        ]),
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseMissing('stories', [
        'id' => $this->story->id,
    ]);

    $this->assertDatabaseHas('stories', [
        'id' => $nestedStory->id,
    ]);
});
test('nested stories can be moved and deleted when deleting the parent story', function () {
    $nestedStory1 = Story::factory()->withParent($this->story)->create();
    $nestedStory2 = Story::factory()->withParent($this->story)->create();

    $this->signInWithPermission('story.delete');

    $this->followingRedirects();

    $response = $this->delete(route('stories.destroy'), [
        'actions' => json_encode([
            $this->story->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
            $nestedStory1->id => [
                'story' => ['action' => 'move', 'actionId' => null],
                'posts' => ['action' => 'nothing', 'actionId' => null],
            ],
            $nestedStory2->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'nothing', 'actionId' => null],
            ],
        ]),
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseMissing('stories', [
        'id' => $this->story->id,
    ]);

    $this->assertDatabaseHas('stories', [
        'id' => $nestedStory1->id,
    ]);

    $this->assertDatabaseMissing('stories', [
        'id' => $nestedStory2->id,
    ]);
});
test('story posts can be deleted when deleting the story', function () {
    Post::factory()->count(5)->create([
        'story_id' => $this->story,
    ]);

    $this->story->refresh();

    $this->signInWithPermission('story.delete');

    $this->followingRedirects();

    $response = $this->delete(route('stories.destroy'), [
        'actions' => json_encode([
            $this->story->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
        ]),
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseMissing('stories', [
        'id' => $this->story->id,
    ]);

    $this->assertDatabaseMissing('posts', [
        'story_id' => $this->story->id,
    ]);
});
test('story posts can be moved when deleting the story', function () {
    Post::factory()->count(5)->create([
        'story_id' => $this->story,
    ]);

    $this->story->refresh();

    $newStory = Story::factory()->create();

    $this->signInWithPermission('story.delete');

    $this->followingRedirects();

    $response = $this->delete(route('stories.destroy'), [
        'actions' => json_encode([
            $this->story->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'move', 'actionId' => $newStory->id],
            ],
        ]),
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseMissing('stories', [
        'id' => $this->story->id,
    ]);

    $this->assertDatabaseHas('posts', [
        'story_id' => $newStory->id,
    ]);
});
test('story posts can be deleted and moved when deleting a story', function () {
    $story1 = Story::factory()->create();
    $story2 = Story::factory()->create();

    Post::factory()->count(5)->create([
        'story_id' => $this->story,
    ]);

    Post::factory()->count(5)->create([
        'story_id' => $story1,
    ]);

    $this->story->refresh();

    $this->signInWithPermission('story.delete');

    $this->followingRedirects();

    $response = $this->delete(route('stories.destroy'), [
        'actions' => json_encode([
            $this->story->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'move', 'actionId' => $story2->id],
            ],
            $story1->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
        ]),
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseMissing('stories', [
        'id' => $this->story->id,
    ]);

    $this->assertDatabaseMissing('stories', [
        'id' => $story1->id,
    ]);

    $this->assertDatabaseHas('posts', [
        'story_id' => $story2->id,
    ]);

    $this->assertDatabaseMissing('posts', [
        'story_id' => $story1->id,
    ]);
});
test('unauthorized user cannot view the delete stories page', function () {
    $this->signIn();

    $response = $this->get(route('stories.delete', $this->story));
    $response->assertNotFound();
});
test('unauthorized user cannot delete story', function () {
    $this->signIn();

    $response = $this->delete(route('stories.destroy'));
    $response->assertNotFound();
});
test('unauthenticated user cannot view the delete stories page', function () {
    $response = $this->getJson(route('stories.delete', $this->story));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot delete story', function () {
    $response = $this->deleteJson(route('stories.destroy'));
    $response->assertUnauthorized();
});
