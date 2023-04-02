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
                // $method = "{$data->direction}Node";

                // $story->{$method}($data->neighbor)->save();

                Story::query()
                    ->where('sort', $data->direction === 'before' ? '>=' : '>', $data->neighbor->sort)
                    ->increment('sort');

                $story->update(['sort' => $data->direction === 'before' ? $data->neighbor->sort : $data->neighbor->sort + 1]);
            }
        }
    }
}
