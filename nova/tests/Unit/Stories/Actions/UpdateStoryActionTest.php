<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Stories\Actions\UpdateStory;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group stories
 */
class UpdateStoryActionTest extends TestCase
{
    use RefreshDatabase;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create([
            'parent_id' => 1,
        ]);
    }

    /** @test **/
    public function itUpdatesAStory()
    {
        $data = StoryData::from([
            'title' => 'Story Title',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            'end_date' => '2020-02-01',
            'start_date' => '2020-01-01',
            'summary' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            'parent_id' => $this->story->parent_id,
        ]);

        $story = UpdateStory::run($this->story, $data);

        $this->assertTrue($story->exists);

        $this->assertEquals('Story Title', $story->title);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->description);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->summary);
        $this->assertEquals(1, $story->parent_id);
        $this->assertEquals('2020-01-01', $story->start_date->format('Y-m-d'));
        $this->assertEquals('2020-02-01', $story->end_date->format('Y-m-d'));
    }

    /** @test **/
    public function itCanChangeTheSortOrderOfAStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = Story::factory()->create([
            'title' => 'New First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();

        $data = StoryData::from([
            'title' => $this->story->title,
            'parent_id' => $this->story->parent_id,
        ]);

        $story = UpdateStory::run($this->story, $data);

        $firstStory->refresh();

        $this->assertEquals(1, $story->parent_id);
        $this->assertEquals(2, $story->_lft);
        $this->assertEquals(4, $firstStory->_lft);
    }
}
