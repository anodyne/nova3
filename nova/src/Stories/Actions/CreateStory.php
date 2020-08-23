<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStory
{
    use RefreshDatabase;

    public function execute(StoryData $data): Story
    {
        $story = Story::create(
            $data->except('parent_id', 'displayDirection', 'displayStoryId')->toArray()
        );

        $parentStory = ($data->parent_id)
            ? Story::find($data->parent_id)
            : Story::find(1);

        $story->appendToNode($parentStory);

        if ($data->displayDirection && $data->displayStoryId) {
            $method = "{$data->displayDirection}Node";

            $story->{$method}(Story::find($data->displayStoryId))->save();
        }

        return $story;
    }
}
