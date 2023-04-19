<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\StoryPositionData;
use Nova\Stories\Models\Story;

class SetStoryPosition
{
    use AsAction;

    public function handle(Story $story, StoryPositionData $data): void
    {
        if ($data->hasPositionChange) {
            if ($data->direction && $data->neighbor) {
                $method = 'move'.ucfirst($data->direction);

                $story->$method($data->neighbor);
            }
        }
    }
}
