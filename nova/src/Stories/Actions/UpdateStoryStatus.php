<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Stories\Models\States\Current;

class UpdateStoryStatus
{
    public function execute(Story $story, $status): Story
    {
        if ($status === 'current') {
            $story->status->transitionTo(Current::class);
        }

        if ($status === 'completed') {
            $story->status->transitionTo(Completed::class);
        }

        return $story->refresh();
    }
}
