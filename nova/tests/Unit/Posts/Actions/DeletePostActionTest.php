<?php

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\DeletePost;
use Nova\Posts\Models\Post;
use Tests\TestCase;

/**
 * @group posts
 */
class DeletePostActionTest extends TestCase
{
    use RefreshDatabase;

    protected DeletePost $action;

    protected Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeletePost::class);

        $this->post = Post::factory()->create();
    }

    /** @test **/
    public function itDeletesAPost()
    {
        $post = $this->action->execute($this->post);

        $this->assertFalse($post->exists);
    }
}
