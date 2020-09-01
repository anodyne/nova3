<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Nova\Stories\Actions\MoveStoryPosts;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 * @group posts
 */
class MoveStoryPostsActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $newStory;

    protected $story;

    protected $posts;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(MoveStoryPosts::class);

        $this->newStory = create(Story::class);

        $this->story = create(Story::class);

        factory(Post::class)->times(5)->create([
            'story_id' => $this->story,
        ]);

        $this->story->refresh();
    }

    /** @test **/
    public function itMovesPostsToAnotherStory()
    {
        $this->assertCount(5, $this->story->posts);

        $story = $this->action->execute($this->story, $this->newStory);

        $this->story->refresh();

        $this->assertCount(0, $this->story->posts);
        $this->assertCount(5, $story->posts);
    }
}
