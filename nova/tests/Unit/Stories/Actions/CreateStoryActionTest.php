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
        ]);

        $story = $this->action->execute($data);

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
        $newStory = create(Story::class);

        $data = new StoryData([
            'title' => 'Story Title',
            'parent_id' => $newStory->id,
        ]);

        $story = $this->action->execute($data);

        $this->assertEquals($newStory->id, $story->parent_id);
    }

    /** @test **/
    public function itCreatesAStoryBeforeAnotherStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = create(Story::class, [
            'title' => 'First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();

        $data = new StoryData([
            'title' => 'Story Title',
            'displayDirection' => 'before',
            'displayNeighbor' => $firstStory->id,
        ]);

        $story = $this->action->execute($data);

        $story->refresh();
        $firstStory->refresh();

        $this->assertEquals(2, $story->_lft);
        $this->assertEquals(4, $firstStory->_lft);
    }

    /** @test **/
    public function itCreatesAStoryAfterAnotherStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = create(Story::class, [
            'title' => 'First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();

        $data = new StoryData([
            'title' => 'Story Title',
            'displayDirection' => 'after',
            'displayNeighbor' => $firstStory->id,
        ]);

        $story = $this->action->execute($data);

        $story->refresh();
        $firstStory->refresh();

        $this->assertEquals(2, $firstStory->_lft);
        $this->assertEquals(4, $story->_lft);
    }

    /** @test **/
    public function itCreatesANestedStoryBeforeAnotherStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = create(Story::class, [
            'title' => 'First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();
        $firstStory->refresh();

        $secondStory = create(Story::class, [
            'title' => 'Second Story',
        ]);
        $secondStory->appendToNode($firstStory)->save();

        $data = new StoryData([
            'title' => 'Story Title',
            'parent_id' => $firstStory->id,
            'displayDirection' => 'before',
            'displayNeighbor' => $secondStory->id,
        ]);

        $story = $this->action->execute($data);

        $story->refresh();
        $firstStory->refresh();
        $secondStory->refresh();

        $this->assertEquals($firstStory->id, $story->parent_id);
        $this->assertEquals(3, $story->_lft);
        $this->assertEquals(5, $secondStory->_lft);
    }

    /** @test **/
    public function itCreatesANestedStoryAfterAnotherStory()
    {
        $mainTimeline = Story::find(1);

        $firstStory = create(Story::class, [
            'title' => 'First Story',
        ]);
        $firstStory->appendToNode($mainTimeline)->save();
        $firstStory->refresh();

        $secondStory = create(Story::class, [
            'title' => 'Second Story',
        ]);
        $secondStory->appendToNode($firstStory)->save();

        $data = new StoryData([
            'title' => 'Story Title',
            'parent_id' => $firstStory->id,
            'displayDirection' => 'after',
            'displayNeighbor' => $secondStory->id,
        ]);

        $story = $this->action->execute($data);

        $story->refresh();
        $firstStory->refresh();
        $secondStory->refresh();

        $this->assertEquals($firstStory->id, $story->parent_id);
        $this->assertEquals(5, $story->_lft);
        $this->assertEquals(3, $secondStory->_lft);
    }
}
