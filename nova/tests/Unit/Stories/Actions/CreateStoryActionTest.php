<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Stories\Actions\CreateStory;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group stories
 */
class CreateStoryActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function itCreatesAStory()
    {
        $data = StoryData::from([
            'title' => 'Story Title',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            'end_date' => '2020-02-01',
            'start_date' => '2020-01-01',
            'summary' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            'parent' => Story::first(),
        ]);

        $story = CreateStory::run($data);

        $this->assertTrue($story->exists);

        $this->assertEquals('Story Title', $story->title);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->description);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->summary);
        $this->assertEquals(1, $story->parent_id);
        $this->assertEquals('2020-01-01', $story->start_date->format('Y-m-d'));
        $this->assertEquals('2020-02-01', $story->end_date->format('Y-m-d'));
    }

    /** @test **/
    public function itCreatesANestedStory()
    {
        $newStory = Story::factory()->create();

        $data = StoryData::from([
            'title' => 'Story Title',
            'parent_id' => $newStory->id,
            'parent' => $newStory,
        ]);

        $story = CreateStory::run($data);

        $this->assertEquals($newStory->id, $story->parent_id);
    }
}
