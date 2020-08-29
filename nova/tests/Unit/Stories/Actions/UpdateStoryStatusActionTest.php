<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;
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
}
