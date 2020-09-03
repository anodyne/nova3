<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Nova\Stories\Actions\CreateStory;
use Nova\Stories\DataTransferObjects\StoryData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 */
class CreateStoryActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateStory::class);
    }

    /** @test **/
    public function itCreatesAStory()
    {
        $data = new StoryData([
            'title' => 'Story Title',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            'end_date' => '2020-02-01',
            'start_date' => '2020-01-01',
            'summary' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            'allow_posting' => true,
        ]);

        $story = $this->action->execute($data);

        $this->assertTrue($story->exists);

        $this->assertEquals('Story Title', $story->title);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->description);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur, adipisicing elit.', $story->summary);
        $this->assertEquals(1, $story->parent_id);
        $this->assertEquals('2020-01-01', $story->start_date->format('Y-m-d'));
        $this->assertEquals('2020-02-01', $story->end_date->format('Y-m-d'));
        $this->assertTrue($story->allow_posting);
    }

    /** @test **/
    public function itCreatesANestedStory()
    {
        $newStory = create(Story::class);

        $data = new StoryData([
            'title' => 'Story Title',
            'parent_id' => $newStory->id,
            'allow_posting' => true,
        ]);

        $story = $this->action->execute($data);

        $this->assertEquals($newStory->id, $story->parent_id);
    }
}
