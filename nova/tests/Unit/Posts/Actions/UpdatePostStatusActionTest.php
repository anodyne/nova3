<?php

declare(strict_types=1);

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\UpdatePostStatus;
use Nova\Posts\Data\PostStatusData;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Pending;
use Nova\Posts\Models\States\Published;
use Tests\TestCase;

/**
 * @group storytelling
 * @group posts
 */
class UpdatePostStatusActionTest extends TestCase
{
    protected Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->draft()->create();
    }

    /** @test **/
    public function itCanUpdateThePostStatus()
    {
        $this->assertTrue($this->post->status->equals(Draft::class));

        $post = UpdatePostStatus::run($this->post, PostStatusData::from([
            'status' => 'published',
        ]));

        $this->assertTrue($post->status->equals(Published::class));
    }

    /** @test **/
    public function itCannotTransitionToTheStatusItsInNow()
    {
        $post = UpdatePostStatus::run($this->post, PostStatusData::from([
            'status' => 'draft',
        ]));

        $this->assertTrue($post->status->equals(Draft::class));
    }

    /** @test **/
    public function itCanTransitionFromDraftToPublished()
    {
        $post = Post::factory()->draft()->create();

        $post = UpdatePostStatus::run($post, PostStatusData::from([
            'status' => 'published',
        ]));

        $this->assertTrue($post->status->equals(Published::class));
        $this->assertNotNull($post->published_at);
    }

    /** @test **/
    public function itCanTransitionFromDraftToPending()
    {
        $post = Post::factory()->draft()->create();

        $post = UpdatePostStatus::run($post, PostStatusData::from([
            'status' => 'pending',
        ]));

        $this->assertTrue($post->status->equals(Pending::class));
        $this->assertNull($post->published_at);
    }

    /** @test **/
    public function itCanTransitionFromPendingToPublished()
    {
        $post = Post::factory()->pending()->create();

        $post = UpdatePostStatus::run($post, PostStatusData::from([
            'status' => 'published',
        ]));

        $this->assertTrue($post->status->equals(Published::class));
        $this->assertNotNull($post->published_at);
    }
}
