<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;

class UpdateStory
{
    use AsAction;

    public function handle(Story $story, StoryData $data): Story
    {
        return tap($story)
            ->update($data->all())
            ->refresh();
    }
}
