<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

use Nova\Stories\Models\Story;
use Spatie\ModelStates\Transition;

class CurrentToUpcoming extends Transition
{
    protected $story;

    public function __construct(Story $story)
    {
        $this->story = $story;
    }

    public function handle(): Story
    {
        $this->story->status = Upcoming::class;
        $this->story->start_date = null;
        $this->story->end_date = null;
        $this->story->save();

        return $this->story->refresh();
    }
}
