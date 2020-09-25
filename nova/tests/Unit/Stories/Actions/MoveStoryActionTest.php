<?php

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

    protected $action;

    protected $newStory;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(MoveStory::class);

        $this->newStory = Story::factory()->create();

        $this->story = Story::factory()->create();
    }

    /** @test **/
    public function itMovesAStory()
    {
        $story = $this->action->execute($this->story, $this->newStory);

        $this->assertEquals($this->newStory->id, $story->parent_id);
    }
}
