<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Stories\Actions\UpdateStoryStatus;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group stories
 */
class UpdateStoryStatusActionTest extends TestCase
{
    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->upcoming()->create();
    }

    /** @test **/
    public function itCanUpdateTheStoryStatus()
    {
        $this->assertTrue($this->story->status->equals(Upcoming::class));

        $story = UpdateStoryStatus::run($this->story, 'current');

        $this->assertTrue($story->status->equals(Current::class));
    }

    /** @test **/
    public function itCannotTransitionToTheStatusItsInNow()
    {
        $story = UpdateStoryStatus::run($this->story, 'upcoming');

        $this->assertTrue($story->status->equals(Upcoming::class));
    }

    /** @test **/
    public function itCanTransitionFromUpcomingToCurrent()
    {
        $story = Story::factory()->upcoming()->create();

        $story = UpdateStoryStatus::run($story, 'current');

        $this->assertTrue($story->status->equals(Current::class));
        $this->assertNotNull($story->start_date);
    }

    /** @test **/
    public function itCanTransitionFromUpcomingToCompleted()
    {
        $story = Story::factory()->upcoming()->create();

        $story = UpdateStoryStatus::run($story, 'completed');

        $this->assertTrue($story->status->equals(Completed::class));
        $this->assertNotNull($story->start_date);
        $this->assertNotNull($story->end_date);
    }

    /** @test **/
    public function itCanTransitionFromCurrentToUpcoming()
    {
        $story = Story::factory()->current()->create([
            'start_date' => now(),
        ]);

        $story = UpdateStoryStatus::run($story, 'upcoming');

        $this->assertTrue($story->status->equals(Upcoming::class));
        $this->assertNull($story->start_date);
        $this->assertNull($story->end_date);
    }

    /** @test **/
    public function itCanTransitionFromCurrentToCompleted()
    {
        $story = Story::factory()->current()->create([
            'start_date' => now(),
        ]);

        $story = UpdateStoryStatus::run($story, 'completed');

        $this->assertTrue($story->status->equals(Completed::class));
        $this->assertNotNull($story->start_date);
        $this->assertNotNull($story->end_date);
    }

    /** @test **/
    public function itCanTransitionFromCompletedToUpcoming()
    {
        $story = Story::factory()->completed()->create([
            'start_date' => now(),
            'end_date' => now(),
        ]);

        $story = UpdateStoryStatus::run($story, 'upcoming');

        $this->assertTrue($story->status->equals(Upcoming::class));
        $this->assertNull($story->start_date);
        $this->assertNull($story->end_date);
    }

    /** @test **/
    public function itCanTransitionFromCompletedToCurrent()
    {
        $story = Story::factory()->completed()->create([
            'start_date' => now(),
            'end_date' => now(),
        ]);

        $story = UpdateStoryStatus::run($story, 'current');

        $this->assertTrue($story->status->equals(Current::class));
        $this->assertNotNull($story->start_date);
        $this->assertNull($story->end_date);
    }
}
