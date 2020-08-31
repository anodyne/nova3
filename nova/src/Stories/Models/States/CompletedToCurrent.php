<?php

namespace Nova\Stories\Models\States;

use Nova\Stories\Models\Story;
use Spatie\ModelStates\Transition;

class CompletedToCurrent extends Transition
{
    protected $story;

    public function __construct(Story $story)
    {
        $this->story = $story;
    }

    public function handle(): Story
    {
        $this->story->status = Current::class;
        $this->story->end_date = null;
        $this->story->save();

        return $this->story->refresh();
    }
}
