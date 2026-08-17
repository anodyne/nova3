<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\StoryPositionData;
use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Models\Story;

class SetStoryPosition
{
    use AsAction;

    public function handle(Story $story, StoryPositionData $data): void
    {
        if (! $data->hasPositionChange) {
            return;
        }

        match ($data->direction) {
            PositionDirection::After => $data->neighbor ? $story->moveAfter($data->neighbor) : null,
            PositionDirection::Before => $data->neighbor ? $story->moveBefore($data->neighbor) : null,
            PositionDirection::Start => $story->moveToStart(),
            PositionDirection::End => $story->moveToEnd(),
        };
    }
}
