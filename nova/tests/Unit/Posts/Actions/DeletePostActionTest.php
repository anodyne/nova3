<?php

declare(strict_types=1);

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

    protected Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create();
    }

    /** @test **/
    public function itDeletesAPost()
    {
        $post = DeletePost::run($this->post);

        $this->assertFalse($post->exists);
    }
}
