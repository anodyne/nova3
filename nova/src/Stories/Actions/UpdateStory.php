<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;

class UpdateStory extends Action
{
    public function handle(Story $story, StoryData $data): Story
    {
        return tap($story)
            ->update($data->toArray())
            ->refresh();
    }
}
