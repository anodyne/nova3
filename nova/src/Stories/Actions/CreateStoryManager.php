<?php

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;

class CreateStoryManager
{
    protected CreateStory $createStory;

    protected UpdateStoryStatus $updateStatus;

    public function __construct(
        CreateStory $createStory,
        UpdateStoryStatus $updateStatus
    ) {
        $this->createStory = $createStory;
        $this->updateStatus = $updateStatus;
    }

    public function execute(Request $request): Story
    {
        $story = $this->createStory->execute(
            $data = StoryData::fromRequest($request),
            $request
        );

        // $this->updateStatus->execute($story, $data);

        return $story->refresh();
    }
}
