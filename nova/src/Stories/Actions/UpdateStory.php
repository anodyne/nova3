<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;

class UpdateStory
{
    public function execute(Story $story, StoryData $data): Story
    {
        dd(Story::defaultOrder()->get()->toTree());

        $story = tap($story)->update(
            $data->except('displayDirection', 'displayNeighbor')->toArray()
        );

        if ($data->displayDirection && $data->displayNeighbor) {
            $method = "{$data->displayDirection}Node";

            $story->{$method}(Story::find($data->displayNeighbor))->save();
        }

        return $story;
    }
}
