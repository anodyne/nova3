<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\DataTransferObjects\StoryData;
use Nova\Stories\Models\Story;

class CreateStory
{
    use AsAction;

    public function handle(StoryData $data): Story
    {
        $story = Story::create(
            $data->except('parent_id', 'displayDirection', 'displayNeighbor')->toArray()
        );

        $parentStory = ($data->parent_id)
            ? Story::find($data->parent_id)
            : Story::find(1);

        $story->appendToNode($parentStory);

        return $story;
    }
}
