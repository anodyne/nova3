<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryPositionData;

class SetStoryPosition
{
    public function execute(Story $story, StoryPositionData $data): void
    {
        if ($data->hasPositionChange) {
            if ($data->displayDirection && $data->displayNeighbor) {
                $method = "{$data->displayDirection}Node";

                $story->{$method}(Story::find($data->displayNeighbor))->save();
            }
        }
    }
}
