<?php

namespace Tests\Unit\Posts\Actions;

use Tests\TestCase;
use Nova\Posts\Models\Post;
use Nova\Posts\Actions\DeletePost;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group posts
 */
class DeletePostActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $post;

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
