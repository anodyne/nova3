<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

use Nova\Stories\Models\Story;
use Spatie\ModelStates\Transition;

class UpcomingToOngoing extends Transition
{
    public function __construct(
        protected Story $story
    ) {
    }

    public function handle(): Story
    {
        $this->story->status = Ongoing::class;
        $this->story->start_date = now();
        $this->story->end_date = null;
        $this->story->save();

        return $this->story->refresh();
    }
}