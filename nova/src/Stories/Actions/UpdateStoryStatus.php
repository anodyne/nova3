<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Stories\Models\States\Current;
use Nova\Stories\DataTransferObjects\StoryData;

class UpdateStoryStatus
{
    public function execute(Story $story, StoryData $data): Story
    {
        if ($data->status === 'current') {
            $story->status->transitionTo(Current::class);
        }

        if ($data->status === 'completed') {
            $story->status->transitionTo(Completed::class);
        }

        return $story->refresh();
    }
}
