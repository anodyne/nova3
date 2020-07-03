<?php

namespace Nova\Stories\Models\States\Stories;

use Nova\Stories\Models\Story;
use Spatie\ModelStates\Transition;

class UpcomingToCurrent extends Transition
{
    protected $story;

    public function __construct(Story $story)
    {
        $this->story = $story;
    }

    public function handle(): Story
    {
        $this->story->status = Current::class;
        $this->story->start_date = now();
        $this->story->save();

        return $this->story->refresh();
    }
}
