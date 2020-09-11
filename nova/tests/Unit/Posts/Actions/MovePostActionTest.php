<?php

namespace Tests\Unit\Posts\Actions;

use Tests\TestCase;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Nova\Posts\Actions\MovePost;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group posts
 * @group stories
 */
class MovePostActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $story;

    protected $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(MovePost::class);

        $this->story = Story::factory()->create();

        $this->post = Post::factory()->create();
    }

    /** @test **/
    public function itMovesAPost()
    {
        $post = $this->action->execute($this->post, $this->story);

        $this->assertEquals($this->story->id, $post->story_id);
    }
}
