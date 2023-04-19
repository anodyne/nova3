<?php

declare(strict_types=1);

namespace Tests\Unit\PostTypes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Actions\DuplicatePostType;
use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

/**
 * @group storytelling
 * @group post-types
 */
class DuplicatePostTypeActionTest extends TestCase
{
    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = PostType::factory()->create([
            'sort' => 0,
            'role_id' => 1,
        ]);
    }

    /** @test **/
    public function itDuplicatesAPostType()
    {
        $postType = DuplicatePostType::run($this->postType);

        $this->assertEquals(
            "Copy of {$this->postType->name}",
            $postType->name
        );
        $this->assertEquals(PostType::count() - 1, $postType->sort);
        $this->assertEquals(1, $postType->role_id);
    }
}
