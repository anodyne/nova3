<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

use Nova\Stories\Events\StoryEnded;
use Nova\Stories\Models\Story;
use Spatie\ModelStates\Transition;

class CurrentToCompleted extends Transition
{
    use ManageParentStoryStatus;

    public function __construct(
        protected Story $story
    ) {
    }

    public function handle(): Story
    {
        $this->story->status = Completed::class;
        $this->story->ended_at = now();
        $this->story->save();

        StoryEnded::dispatch($this->story);

        $this->updateParentStoryToCompletedIfAble();

        return $this->story->refresh();
    }
}
