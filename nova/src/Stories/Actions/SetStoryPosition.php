<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\DataTransferObjects\StoryPositionData;
use Nova\Stories\Models\Story;

class SetStoryPosition
{
    use AsAction;

    public function handle(Story $story, StoryPositionData $data): void
    {
        if ($data->hasPositionChange) {
            if ($data->direction && $data->neighbor) {
                $method = "{$data->direction}Node";

                $story->{$method}($data->neighbor)->save();
            }
        }
    }
}
