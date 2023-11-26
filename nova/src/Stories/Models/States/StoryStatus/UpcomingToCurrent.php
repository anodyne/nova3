<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

use Nova\Stories\Events\StoryStarted as StoryStartedEvent;
use Nova\Stories\Models\Story;
use Nova\Stories\Notifications\StoryStarted;
use Nova\Users\Models\User;
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

        User::active()->get()->each->notify(new StoryStarted($this->story));

        StoryStartedEvent::dispatch($this->story);

        $this->updateParentStoryToOngoing();

        return $this->story->refresh();
    }
}
