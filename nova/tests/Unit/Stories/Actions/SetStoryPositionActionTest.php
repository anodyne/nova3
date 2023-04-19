<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Nova\Stories\Actions\SetStoryPosition;
use Nova\Stories\Data\StoryPositionData;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group stories
 */
class SetStoryPositionActionTest extends TestCase
{
    protected Story $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();
    }

    /** @test **/
    public function itMovesAStoryBeforeAnotherStory()
    {
        $this->assertEquals(1, $this->story->order_column);

        $newFirstStory = Story::factory()->create();

        $data = StoryPositionData::from([
            'direction' => 'before',
            'neighbor' => $this->story,
            'hasPositionChange' => true,
        ]);

        SetStoryPosition::run($newFirstStory, $data);

        $this->story->refresh();
        $newFirstStory->refresh();

        $this->assertEquals(1, $newFirstStory->order_column);
        $this->assertEquals(2, $this->story->order_column);
    }

    /** @test **/
    public function itMovesAStoryAfterAnotherStory()
    {
        $secondStory = Story::factory()->create();

        $secondStory->refresh();

        $this->assertEquals(1, $this->story->order_column);
        $this->assertEquals(2, $secondStory->order_column);

        $newSecondStory = Story::factory()->create();

        $data = StoryPositionData::from([
            'direction' => 'after',
            'neighbor' => $this->story,
            'hasPositionChange' => true,
        ]);

        SetStoryPosition::run($newSecondStory, $data);

        $this->story->refresh();
        $newSecondStory->refresh();
        $secondStory->refresh();

        $this->assertEquals(1, $this->story->order_column);
        $this->assertEquals(2, $newSecondStory->order_column);
        $this->assertEquals(3, $secondStory->order_column);
    }

    /** @test **/
    public function itMovesANestedStoryBeforeAnotherStoryWithTheSameParent()
    {
        $secondRootStory = Story::factory()->create();

        $firstStory = Story::factory()->withParent($this->story)->create();

        $secondStory = Story::factory()->withParent($this->story)->create();

        $firstStory->refresh();
        $secondStory->refresh();

        $data = StoryPositionData::from([
            'direction' => 'before',
            'neighbor' => $firstStory,
            'hasPositionChange' => true,
        ]);

        SetStoryPosition::run($secondStory, $data);

        $this->story->refresh();
        $secondRootStory->refresh();
        $firstStory->refresh();
        $secondStory->refresh();

        $this->assertEquals(1, $this->story->order_column);
        $this->assertEquals(2, $secondRootStory->order_column);
        $this->assertEquals(1, $secondStory->order_column);
        $this->assertEquals(2, $firstStory->order_column);
    }

    /** @test **/
    public function itMovesANestedStoryAfterAnotherStoryWithTheSameParent()
    {
        $secondRootStory = Story::factory()->create();

        $firstStory = Story::factory()->withParent($this->story)->create();

        $secondStory = Story::factory()->withParent($this->story)->create();

        $thirdStory = Story::factory()->withParent($this->story)->create();

        $firstStory->refresh();
        $secondStory->refresh();
        $thirdStory->refresh();

        $data = StoryPositionData::from([
            'direction' => 'after',
            'neighbor' => $firstStory,
            'hasPositionChange' => true,
        ]);

        SetStoryPosition::run($thirdStory, $data);

        $this->story->refresh();
        $secondRootStory->refresh();
        $firstStory->refresh();
        $secondStory->refresh();
        $thirdStory->refresh();

        $this->assertEquals(1, $this->story->order_column);
        $this->assertEquals(2, $secondRootStory->order_column);
        $this->assertEquals(1, $firstStory->order_column);
        $this->assertEquals(2, $thirdStory->order_column);
        $this->assertEquals(3, $secondStory->order_column);
    }
}
