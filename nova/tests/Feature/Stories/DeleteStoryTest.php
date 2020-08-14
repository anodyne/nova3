<?php

namespace Tests\Feature\Stories;

use Tests\TestCase;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryDeleted;
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
    public function authorizedUserCanDeleteStory()
    {
        $this->withoutExceptionHandling();

        $this->signInWithPermission('story.delete');

        $this->followingRedirects();

        $response = $this->delete(route('stories.destroy', $this->story));
        $response->assertSuccessful();

        $this->assertDatabaseMissing('stories', [
            'id' => $this->story->id,
        ]);
    }

    /** @test **/
    public function whenAStoryIsDeletedItDeletesAllItsStoryPosts()
    {
        $this->withoutExceptionHandling();

        $this->signInWithPermission('story.delete');

        $post = create(Post::class, [
            'story_id' => $this->story->id,
        ]);

        $this->followingRedirects();

        $response = $this->delete(route('stories.destroy', $this->story));
        $response->assertSuccessful();

        $this->assertDatabaseMissing('stories', [
            'id' => $this->story->id,
        ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenStoryIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('story.delete');

        $this->delete(route('stories.destroy', $this->story));

        Event::assertDispatched(StoryDeleted::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteStory()
    {
        $this->signIn();

        $response = $this->delete(route('stories.destroy', $this->story));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteStory()
    {
        $response = $this->deleteJson(route('stories.destroy', $this->story));
        $response->assertUnauthorized();
    }
}
