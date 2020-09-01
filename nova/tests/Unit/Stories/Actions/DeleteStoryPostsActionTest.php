<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Nova\Stories\Actions\DeleteStoryPosts;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 * @group posts
 */
class DeleteStoryPostsActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $story;

    protected $posts;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteStoryPosts::class);

        $this->story = create(Story::class);

        $this->posts = factory(Post::class)->times(5)->create([
            'story_id' => $this->story,
        ]);

        $this->story->refresh();
    }

    /** @test **/
    public function itDeletesThePostsInAStory()
    {
        $this->assertCount(5, $this->story->posts);

        $story = $this->action->execute($this->story);

        $this->assertCount(0, $story->posts);
    }
}
