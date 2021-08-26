<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Stories\DataTransferObjects\StoryData;
use Nova\Stories\Models\Story;

class UpdateStory
{
    public function execute(Story $story, StoryData $data): Story
    {
        return tap($story)->update(
            $data->except('displayDirection', 'displayNeighbor')->toArray()
        );
    }
}
