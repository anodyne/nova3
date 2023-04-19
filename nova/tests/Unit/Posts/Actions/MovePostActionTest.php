<?php

declare(strict_types=1);

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\MovePost;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group posts
 */
class MovePostActionTest extends TestCase
{
    protected Story $story;

    protected Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();

        $this->post = Post::factory()->create();
    }

    /** @test **/
    public function itMovesAPost()
    {
        $post = MovePost::run($this->post, $this->story);

        $this->assertEquals($this->story->id, $post->story_id);
    }
}
