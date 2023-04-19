<?php

declare(strict_types=1);

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\CreateRootPost;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group posts
 */
class CreateRootPostActionTest extends TestCase
{
    /** @test **/
    public function itCreatesARootPost()
    {
        $post = CreateRootPost::run($story = Story::factory()->create());

        $this->assertTrue($post->exists);

        $this->assertEquals("{$story->title} Root Post", $post->title);
        $this->assertEquals($story->id, $post->story_id);
        $this->assertNull($post->parent_id);
    }
}
