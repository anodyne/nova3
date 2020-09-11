<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Nova\Stories\Actions\SetStoryPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Stories\DataTransferObjects\StoryPositionData;

/**
 * @group stories
 */
class SetStoryPositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(SetStoryPosition::class);

        $this->story = Story::factory()->create();
    }

    /** @test **/
    public function itCreatesAStoryBeforeAnotherStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = Story::factory()->create([
            'title' => 'First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();

        $data = new StoryPositionData([
            'displayDirection' => 'before',
            'displayNeighbor' => $firstStory->id,
            'hasPositionChange' => true,
        ]);

        $this->action->execute($this->story, $data);

        $this->story->refresh();
        $firstStory->refresh();

        $this->assertEquals(2, $this->story->_lft);
        $this->assertEquals(4, $firstStory->_lft);
    }

    /** @test **/
    public function itCreatesAStoryAfterAnotherStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = Story::factory()->create([
            'title' => 'First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();

        $data = new StoryPositionData([
            'displayDirection' => 'after',
            'displayNeighbor' => $firstStory->id,
            'hasPositionChange' => true,
        ]);

        $this->action->execute($this->story, $data);

        $this->story->refresh();
        $firstStory->refresh();

        $this->assertEquals(2, $firstStory->_lft);
        $this->assertEquals(4, $this->story->_lft);
    }

    /** @test **/
    public function itCreatesANestedStoryBeforeAnotherStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = Story::factory()->create([
            'title' => 'First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();
        $firstStory->refresh();

        $secondStory = Story::factory()->create([
            'title' => 'Second Story',
        ]);
        $secondStory->appendToNode($firstStory)->save();

        $data = new StoryPositionData([
            'parent_id' => $firstStory->id,
            'displayDirection' => 'before',
            'displayNeighbor' => $secondStory->id,
            'hasPositionChange' => true,
        ]);

        $this->action->execute($this->story, $data);

        $this->story->refresh();
        $firstStory->refresh();
        $secondStory->refresh();

        $this->assertEquals($firstStory->id, $this->story->parent_id);
        $this->assertEquals(3, $this->story->_lft);
        $this->assertEquals(5, $secondStory->_lft);
    }

    /** @test **/
    public function itCreatesANestedStoryAfterAnotherStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = Story::factory()->create([
            'title' => 'First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();
        $firstStory->refresh();

        $secondStory = Story::factory()->create([
            'title' => 'Second Story',
        ]);
        $secondStory->appendToNode($firstStory)->save();

        $data = new StoryPositionData([
            'parent_id' => $firstStory->id,
            'displayDirection' => 'after',
            'displayNeighbor' => $secondStory->id,
            'hasPositionChange' => true,
        ]);

        $this->action->execute($this->story, $data);

        $this->story->refresh();
        $firstStory->refresh();
        $secondStory->refresh();

        $this->assertEquals($firstStory->id, $this->story->parent_id);
        $this->assertEquals(5, $this->story->_lft);
        $this->assertEquals(3, $secondStory->_lft);
    }
}
