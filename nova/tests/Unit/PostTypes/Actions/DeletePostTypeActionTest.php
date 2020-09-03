<?php

namespace Tests\Unit\PostTypes\Actions;

use Tests\TestCase;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Actions\DeletePostType;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->postType = create(PostType::class);
    }

    /** @test **/
    public function itDeletesAPostType()
    {
        $postType = $this->action->execute($this->postType);

        $this->assertNotNull($postType->deleted_at);
    }
}
