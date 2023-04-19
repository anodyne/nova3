<?php

declare(strict_types=1);

namespace Tests\Unit\PostTypes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Actions\DeletePostType;
use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

/**
 * @group storytelling
 * @group post-types
 */
class DeletePostTypeActionTest extends TestCase
{
    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = PostType::factory()->create();
    }

    /** @test **/
    public function itDeletesAPostType()
    {
        $postType = DeletePostType::run($this->postType);

        $this->assertNotNull($postType->deleted_at);
    }
}
