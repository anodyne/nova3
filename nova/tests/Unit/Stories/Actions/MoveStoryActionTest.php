<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Stories\Actions\MoveStory;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group stories
 */
class MoveStoryActionTest extends TestCase
{
    use RefreshDatabase;

    protected $newStory;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->newStory = Story::factory()->create();

        $this->story = Story::factory()->create();

        $this->story->refresh();
        $this->newStory->refresh();
    }

    /** @test **/
    public function itMovesAStory()
    {
        $story = MoveStory::run($this->story, $this->newStory);

        $this->assertEquals($this->newStory->id, $story->parent_id);
    }
}
