<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Actions\UpdateStoryStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 */
class UpdateStoryStatusActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateStoryStatus::class);

        $this->story = create(Story::class, [], ['status:upcoming']);
    }

    /** @test **/
    public function itCanUpdateTheStoryStatus()
    {
        $this->assertTrue($this->story->status->equals(Upcoming::class));

        $story = $this->action->execute($this->story, 'current');

        $this->assertTrue($story->status->equals(Current::class));
    }

    /** @test **/
    public function itCannotTransitionToTheStatusItsInNow()
    {
        $story = $this->action->execute($this->story, 'upcoming');

        $this->assertTrue($story->status->equals(Upcoming::class));
    }

    /** @test **/
    public function itCanTransitionFromUpcomingToCurrent()
    {
        $story = create(Story::class, [], ['status:upcoming']);

        $story = $this->action->execute($story, 'current');

        $this->assertTrue($story->status->equals(Current::class));
        $this->assertNotNull($story->start_date);
    }

    /** @test **/
    public function itCanTransitionFromUpcomingToCompleted()
    {
        $story = create(Story::class, [], ['status:upcoming']);

        $story = $this->action->execute($story, 'completed');

        $this->assertTrue($story->status->equals(Completed::class));
        $this->assertNotNull($story->start_date);
        $this->assertNotNull($story->end_date);
    }

    /** @test **/
    public function itCanTransitionFromCurrentToUpcoming()
    {
        $story = create(Story::class, [
            'start_date' => now(),
        ], ['status:current']);

        $story = $this->action->execute($story, 'upcoming');

        $this->assertTrue($story->status->equals(Upcoming::class));
        $this->assertNull($story->start_date);
        $this->assertNull($story->end_date);
    }

    /** @test **/
    public function itCanTransitionFromCurrentToCompleted()
    {
        $story = create(Story::class, [
            'start_date' => now(),
        ], ['status:current']);

        $story = $this->action->execute($story, 'completed');

        $this->assertTrue($story->status->equals(Completed::class));
        $this->assertNotNull($story->start_date);
        $this->assertNotNull($story->end_date);
    }

    /** @test **/
    public function itCanTransitionFromCompletedToUpcoming()
    {
        $story = create(Story::class, [
            'start_date' => now(),
            'end_date' => now(),
        ], ['status:completed']);

        $story = $this->action->execute($story, 'upcoming');

        $this->assertTrue($story->status->equals(Upcoming::class));
        $this->assertNull($story->start_date);
        $this->assertNull($story->end_date);
    }

    /** @test **/
    public function itCanTransitionFromCompletedToCurrent()
    {
        $story = create(Story::class, [
            'start_date' => now(),
            'end_date' => now(),
        ], ['status:completed']);

        $story = $this->action->execute($story, 'current');

        $this->assertTrue($story->status->equals(Current::class));
        $this->assertNotNull($story->start_date);
        $this->assertNull($story->end_date);
    }
}
