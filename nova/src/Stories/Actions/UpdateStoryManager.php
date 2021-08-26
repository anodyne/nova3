<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Stories\DataTransferObjects\StoryData;
use Nova\Stories\DataTransferObjects\StoryPositionData;
use Nova\Stories\Models\Story;

class UpdateStoryManager
{
    protected SetStoryPosition $setStoryPosition;

    protected UpdateStory $updateStory;

    protected UpdateStoryStatus $updateStatus;

    protected UploadStoryImages $uploadImages;

    public function __construct(
        UpdateStory $updateStory,
        UpdateStoryStatus $updateStatus,
        UploadStoryImages $uploadImages,
        SetStoryPosition $setStoryPosition
    ) {
        $this->setStoryPosition = $setStoryPosition;
        $this->updateStory = $updateStory;
        $this->updateStatus = $updateStatus;
        $this->uploadImages = $uploadImages;
    }

    public function execute(Story $story, Request $request): Story
    {
        $story = $this->updateStory->execute(
            $story,
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
