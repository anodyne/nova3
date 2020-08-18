<?php

namespace Tests\Feature\Stories;

use Tests\TestCase;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryDeleted;
use Nova\Stories\Exceptions\StoryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 */
class DeleteStoryTest extends TestCase
{
    use RefreshDatabase;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = create(Story::class);
    }

    /** @test **/
    public function authorizedUserCanViewTheDeleteStoriesPage()
    {
        $this->signInWithPermission('story.delete');

        $response = $this->get(route('stories.delete', $this->story));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanDeleteStory()
    {
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
    }

    /** @test **/
    public function eventIsDispatchedWhenStoryIsDeleted()
    {
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
    }

    /** @test **/
    public function nestedStoriesCanBeDeletedWhenDeletingTheParentStory()
    {
        $this->withoutExceptionHandling();
        $nestedStory = create(Story::class, [
            'parent_id' => $this->story,
        ]);

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
    }

    /** @test **/
    public function nestedStoriesCanBeMovedWhenDeletingTheParentStory()
    {
        $nestedStory = create(Story::class, [
            'parent_id' => $this->story,
        ]);

        $this->signInWithPermission('story.delete');

        $this->followingRedirects();

        $response = $this->delete(route('stories.destroy'), [
            'actions' => json_encode([
                $this->story->id => [
                    'story' => ['action' => 'delete', 'actionId' => null],
                    'posts' => ['action' => 'delete', 'actionId' => null],
                ],
                $nestedStory->id => [
                    'story' => ['action' => 'move', 'actionId' => 1],
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
            'parent_id' => 1,
        ]);
    }

    /** @test **/
    public function nestedStoriesCanBeMovedAndDeletedWhenDeletingTheParentStory()
    {
        $nestedStory1 = create(Story::class, [
            'parent_id' => $this->story,
        ]);

        $nestedStory2 = create(Story::class, [
            'parent_id' => $this->story,
        ]);

        $this->signInWithPermission('story.delete');

        $this->followingRedirects();

        $response = $this->delete(route('stories.destroy'), [
            'actions' => json_encode([
                $this->story->id => [
                    'story' => ['action' => 'delete', 'actionId' => null],
                    'posts' => ['action' => 'delete', 'actionId' => null],
                ],
                $nestedStory1->id => [
                    'story' => ['action' => 'move', 'actionId' => 1],
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
            'parent_id' => 1,
        ]);

        $this->assertDatabaseMissing('stories', [
            'id' => $nestedStory2->id,
        ]);
    }

    /** @test **/
    public function storyPostsCanBeDeletedWhenDeletingTheStory()
    {
        factory(Post::class)->times(5)->create([
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
    }

    /** @test **/
    public function storyPostsCanBeMovedWhenDeletingTheStory()
    {
        factory(Post::class)->times(5)->create([
            'story_id' => $this->story,
        ]);

        $this->story->refresh();

        $newStory = create(Story::class);

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
    }

    /** @test **/
    public function storyPostsCanBeDeletedAndMovedWhenDeletingAStory()
    {
        $story1 = create(Story::class);
        $story2 = create(Story::class);

        factory(Post::class)->times(5)->create([
            'story_id' => $this->story,
        ]);

        factory(Post::class)->times(5)->create([
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
    }

    /** @test **/
    public function mainTimelineCannotBeShownInTheDeleteStoriesPage()
    {
        $this->withoutExceptionHandling();

        $this->signInWithPermission('story.delete');

        $this->expectException(StoryException::class);

        $response = $this->get(route('stories.delete', 1));
    }

    /** @test **/
    public function cannotDeleteTheMainTimeline()
    {
        $this->withoutExceptionHandling();

        $this->signInWithPermission('story.delete');

        $this->expectException(StoryException::class);

        $response = $this->deleteJson(route('stories.destroy'), [
            'actions' => json_encode([
                1 => [
                    'story' => ['action' => 'delete', 'actionId' => null],
                    'posts' => ['action' => 'delete', 'actionId' => null],
                ],
            ]),
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheDeleteStoriesPage()
    {
        $this->signIn();

        $response = $this->get(route('stories.delete', $this->story));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteStory()
    {
        $this->signIn();

        $response = $this->delete(route('stories.destroy'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheDeleteStoriesPage()
    {
        $response = $this->getJson(route('stories.delete', $this->story));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteStory()
    {
        $response = $this->deleteJson(route('stories.destroy'));
        $response->assertUnauthorized();
    }
}
