<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

use Nova\Stories\Events\StoryEnded as StoryEndedEvent;
use Nova\Stories\Models\Story;
use Nova\Stories\Notifications\StoryEnded;
use Nova\Users\Models\User;
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

        User::active()->get()->each->notify(new StoryEnded($this->story));

        StoryEndedEvent::dispatch($this->story);

        $this->updateParentStoryToCompletedIfAble();

        return $this->story->refresh();
    }
}
