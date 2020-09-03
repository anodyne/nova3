<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;

class UpdateStory
{
    public function execute(Story $story, StoryData $data): Story
    {
        return tap($story)->update(
            $data->except('displayDirection', 'displayNeighbor')->toArray()
        );
    }
}
