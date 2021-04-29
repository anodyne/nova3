<?php

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\CreateRootPost;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group posts
 */
class CreateRootPostActionTest extends TestCase
{
    use RefreshDatabase;

    protected CreateRootPost $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateRootPost::class);
    }

    /** @test **/
    public function itCreatesARootPost()
    {
        $post = $this->action->execute($story = Story::factory()->create());

        $this->assertTrue($post->exists);

        $this->assertEquals("{$story->title} Root Post", $post->title);
        $this->assertEquals($story->id, $post->story_id);
        $this->assertNull($post->parent_id);
    }
}
