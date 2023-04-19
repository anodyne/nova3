<?php

declare(strict_types=1);

namespace Tests\Feature\Stories;

use Illuminate\Support\Facades\Event;
use Nova\Posts\Models\Post;
use Nova\Stories\Events\StoryDeleted;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group stories
 */
class DeleteStoryTest extends TestCase
{
    protected Story $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();
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
    }

    /** @test **/
    public function nestedStoriesCanBeMovedWhenDeletingTheParentStory()
    {
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
    }

    /** @test **/
    public function nestedStoriesCanBeMovedAndDeletedWhenDeletingTheParentStory()
    {
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
    }

    /** @test **/
    public function storyPostsCanBeDeletedWhenDeletingTheStory()
    {
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
    }

    /** @test **/
    public function storyPostsCanBeMovedWhenDeletingTheStory()
    {
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
    }

    /** @test **/
    public function storyPostsCanBeDeletedAndMovedWhenDeletingAStory()
    {
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
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheDeleteStoriesPage()
    {
        $this->signIn();

        $response = $this->get(route('stories.delete', $this->story));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteStory()
    {
        $this->signIn();

        $response = $this->delete(route('stories.destroy'));
        $response->assertNotFound();
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
