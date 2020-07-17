<?php

namespace Tests\Unit\PostTypes\Actions;

use Tests\TestCase;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Actions\DuplicatePostType;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 * @group post-types
 */
class DuplicatePostTypeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicatePostType::class);

        $this->postType = create(PostType::class);
    }

    /** @test **/
    public function itDuplicatesAPostType()
    {
        $postType = $this->action->execute($this->postType);

        $this->assertEquals(
            "Copy of {$this->postType->name}",
            $postType->name
        );
    }
}
