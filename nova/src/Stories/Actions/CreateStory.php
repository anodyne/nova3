<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Stories\Models\States\Completed;

class CreateStory
{
    use RefreshDatabase;

    public function execute(StoryData $data): Story
    {
        $story = Story::create(
            $data->except('parent_id', 'displayDirection', 'displayNeighbor')->toArray()
        );

        $parentStory = ($data->parent_id)
            ? Story::find($data->parent_id)
            : Story::find(1);

        $story->appendToNode($parentStory);

        // if (! $parentStory->isMainTimeline() && $parentStory->stories->count() === 0) {
        //     $parentStory->status->transitionTo(Completed::class);
        // }

        return $story;
    }
}
