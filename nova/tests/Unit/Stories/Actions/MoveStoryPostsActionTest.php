<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Models\Post;
use Nova\Stories\Actions\MoveStoryPosts;
use Nova\Stories\Models\Story;
use Tests\TestCase;

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

        $this->newStory = Story::factory()->create();

        $this->story = Story::factory()->create();

        Post::factory()->count(5)->create([
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
