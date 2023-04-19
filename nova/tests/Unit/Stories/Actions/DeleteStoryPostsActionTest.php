<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Models\Post;
use Nova\Stories\Actions\DeleteStoryPosts;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group stories
 * @group posts
 */
class DeleteStoryPostsActionTest extends TestCase
{
    protected $story;

    protected $posts;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();

        $this->posts = Post::factory()->count(5)->create([
            'story_id' => $this->story,
        ]);

        $this->story->refresh();
    }

    /** @test **/
    public function itDeletesThePostsInAStory()
    {
        $this->assertCount(5, $this->story->posts);

        $story = DeleteStoryPosts::run($this->story);

        $this->assertCount(0, $story->posts);
    }
}
