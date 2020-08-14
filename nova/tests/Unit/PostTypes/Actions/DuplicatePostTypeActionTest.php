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

        $this->postType = create(PostType::class, [
            'sort' => 0,
            'role_id' => 1,
        ]);
    }

    /** @test **/
    public function itDuplicatesAPostType()
    {
        $postType = $this->action->execute($this->postType);

        $this->assertEquals(
            "Copy of {$this->postType->name}",
            $postType->name
        );
        $this->assertEquals(PostType::count() - 1, $postType->sort);
        $this->assertEquals(1, $postType->role_id);
    }
}
