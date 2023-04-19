<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;

class CreateStory
{
    use AsAction;

    public function handle(StoryData $data): Story
    {
        return Story::create($data->all());
    }
}
