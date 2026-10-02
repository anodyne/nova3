<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;

class CreateStory extends Action
{
    public function handle(StoryData $data): Story
    {
        return Story::create($data->toArray());
    }
}
