<?php

declare(strict_types=1);

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\UpdatePostStatus;
use Nova\Posts\DataTransferObjects\PostStatusData;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Pending;
use Nova\Posts\Models\States\Published;
use Tests\TestCase;

/**
 * @group posts
 */
class UpdatePostStatusActionTest extends TestCase
{
    use RefreshDatabase;

    protected UpdatePostStatus $action;

    protected Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdatePostStatus::class);

        $this->post = Post::factory()->draft()->create();
    }

    /** @test **/
    public function itCanUpdateThePostStatus()
    {
        $this->assertTrue($this->post->status->equals(Draft::class));

        $post = $this->action->execute($this->post, new PostStatusData([
            'status' => 'published',
        ]));

        $this->assertTrue($post->status->equals(Published::class));
    }

    /** @test **/
    public function itCannotTransitionToTheStatusItsInNow()
    {
        $post = $this->action->execute($this->post, new PostStatusData([
            'status' => 'draft',
        ]));

        $this->assertTrue($post->status->equals(Draft::class));
    }

    /** @test **/
    public function itCanTransitionFromDraftToPublished()
    {
        $post = Post::factory()->draft()->create();

        $post = $this->action->execute($post, new PostStatusData([
            'status' => 'published',
        ]));

        $this->assertTrue($post->status->equals(Published::class));
        $this->assertNotNull($post->published_at);
    }

    /** @test **/
    public function itCanTransitionFromDraftToPending()
    {
        $post = Post::factory()->draft()->create();

        $post = $this->action->execute($post, new PostStatusData([
            'status' => 'pending',
        ]));

        $this->assertTrue($post->status->equals(Pending::class));
        $this->assertNull($post->published_at);
    }

    /** @test **/
    public function itCanTransitionFromPendingToPublished()
    {
        $post = Post::factory()->pending()->create();

        $post = $this->action->execute($post, new PostStatusData([
            'status' => 'published',
        ]));

        $this->assertTrue($post->status->equals(Published::class));
        $this->assertNotNull($post->published_at);
    }
}
