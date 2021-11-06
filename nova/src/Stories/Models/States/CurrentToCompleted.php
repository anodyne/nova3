<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

use Nova\Stories\Models\Story;
use Spatie\ModelStates\Transition;

class CurrentToCompleted extends Transition
{
    public function __construct(
        protected Story $story
    ) {
    }

    public function handle(): Story
    {
        $this->story->status = Completed::class;
        $this->story->end_date = now();
        $this->story->save();

        return $this->story->refresh();
    }
}
