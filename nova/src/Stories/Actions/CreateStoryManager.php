<?php

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;
use Nova\Stories\DataTransferObjects\StoryPositionData;

class CreateStoryManager
{
    protected CreateStory $createStory;

    protected SetStoryPosition $setStoryPosition;

    protected UpdateStoryStatus $updateStatus;

    protected UploadStoryImages $uploadImages;

    public function __construct(
        CreateStory $createStory,
        UpdateStoryStatus $updateStatus,
        UploadStoryImages $uploadImages,
        SetStoryPosition $setStoryPosition
    ) {
        $this->createStory = $createStory;
        $this->setStoryPosition = $setStoryPosition;
        $this->updateStatus = $updateStatus;
        $this->uploadImages = $uploadImages;
    }

    public function execute(Request $request): Story
    {
        $story = $this->createStory->execute(
            StoryData::fromRequest($request)
        );

        $this->setStoryPosition->execute(
            $story,
            StoryPositionData::fromRequest($request)
        );

        $this->updateStatus->execute($story, $request->status);

        $this->uploadImages->execute($story, $request->image_path);

        return $story->refresh();
    }
}
