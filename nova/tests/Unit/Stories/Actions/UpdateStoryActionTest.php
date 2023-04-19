<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Nova\Stories\Actions\UpdateStory;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group stories
 */
class UpdateStoryActionTest extends TestCase
{
    protected Story $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();
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
        ]);

        $story = UpdateStory::run($this->story, $data);

        $this->assertTrue($story->exists);

        $this->assertEquals('Story Title', $story->title);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->description);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->summary);
        $this->assertEquals('2020-01-01', $story->start_date->format('Y-m-d'));
        $this->assertEquals('2020-02-01', $story->end_date->format('Y-m-d'));
    }

    /** @test **/
    public function itCanChangeTheParentOfAStory()
    {
        $firstStory = Story::factory()->withParent($this->story)->create();

        $newParentStory = Story::factory()->create();

        $data = StoryData::from([
            'title' => $this->story->title,
            'parent_id' => $newParentStory->id,
        ]);

        $story = UpdateStory::run($firstStory, $data);

        $firstStory->refresh();

        $this->assertEquals($newParentStory->id, $story->parent_id);
    }
}
