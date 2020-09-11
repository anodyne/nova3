<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Nova\Stories\Actions\MoveStory;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $story = $this->action->execute($this->story, $this->newStory->id);

        $this->assertEquals($this->newStory->id, $story->parent_id);
    }
}
