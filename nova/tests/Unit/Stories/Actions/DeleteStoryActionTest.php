<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Nova\Stories\Actions\DeleteStory;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group stories
 */
class DeleteStoryActionTest extends TestCase
{
    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();
    }

    /** @test **/
    public function itDeletesAStory()
    {
        $story = DeleteStory::run($this->story);

        $this->assertFalse($story->exists);
    }
}
