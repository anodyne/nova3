<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

use Nova\Stories\Models\Story;
use Spatie\ModelStates\Transition;

class UpcomingToCurrent extends Transition
{
    use ManageParentStoryStatus;

    public function __construct(
        protected Story $story
    ) {
    }

    public function handle(): Story
    {
        $this->story->status = Current::class;
        $this->story->started_at = now();
        $this->story->ended_at = null;
        $this->story->save();

        $this->updateParentStoryToOngoing();

        return $this->story->refresh();
    }
}
