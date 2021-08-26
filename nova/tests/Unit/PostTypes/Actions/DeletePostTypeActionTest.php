<?php

declare(strict_types=1);

namespace Tests\Unit\PostTypes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Actions\DeletePostType;
use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

/**
 * @group stories
 * @group post-types
 */
class DeletePostTypeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeletePostType::class);

        $this->postType = PostType::factory()->create();
    }

    /** @test **/
    public function itDeletesAPostType()
    {
        $postType = $this->action->execute($this->postType);

        $this->assertNotNull($postType->deleted_at);
    }
}
