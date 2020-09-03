<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Nova\Stories\Actions\UpdateStory;
use Nova\Stories\DataTransferObjects\StoryData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 */
class UpdateStoryActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateStory::class);

        $this->story = create(Story::class, [
            'parent_id' => 1,
        ]);
    }

    /** @test **/
    public function itUpdatesAStory()
    {
        $data = new StoryData([
            'title' => 'Story Title',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            'end_date' => '2020-02-01',
            'start_date' => '2020-01-01',
            'summary' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            'parent_id' => $this->story->parent_id,
            'allow_posting' => false,
        ]);

        $story = $this->action->execute($this->story, $data);

        $this->assertTrue($story->exists);

        $this->assertEquals('Story Title', $story->title);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->description);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->summary);
        $this->assertEquals(1, $story->parent_id);
        $this->assertEquals('2020-01-01', $story->start_date->format('Y-m-d'));
        $this->assertEquals('2020-02-01', $story->end_date->format('Y-m-d'));
        $this->assertFalse($story->allow_posting);
    }

    /** @test **/
    public function itCanChangeTheSortOrderOfAStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = create(Story::class, [
            'title' => 'New First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();

        $data = new StoryData([
            'title' => $this->story->title,
            'parent_id' => $this->story->parent_id,
            'allow_posting' => true,
        ]);

        $story = $this->action->execute($this->story, $data);

        $firstStory->refresh();

        $this->assertEquals(1, $story->parent_id);
        $this->assertEquals(2, $story->_lft);
        $this->assertEquals(4, $firstStory->_lft);
    }
}
