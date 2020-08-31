<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;

class SetStorySort
{
    public function execute(Story $story, StoryData $data): void
    {
        if ($data->displayDirection && $data->displayNeighbor) {
            $method = "{$data->displayDirection}Node";

            $story->{$method}(Story::find($data->displayNeighbor))->save();
        }
    }
}
