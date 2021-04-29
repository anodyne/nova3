<?php

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Posts\Actions\CreateRootPost;
use Nova\Stories\DataTransferObjects\StoryData;
use Nova\Stories\DataTransferObjects\StoryPositionData;
use Nova\Stories\Models\Story;

class CreateStoryManager
{
    protected CreateRootPost $createRootPost;

    protected CreateStory $createStory;

    protected SetStoryPosition $setStoryPosition;

    protected UpdateStoryStatus $updateStatus;

    protected UploadStoryImages $uploadImages;

    public function __construct(
        CreateRootPost $createRootPost,
        CreateStory $createStory,
        UpdateStoryStatus $updateStatus,
        UploadStoryImages $uploadImages,
        SetStoryPosition $setStoryPosition
    ) {
        $this->createRootPost = $createRootPost;
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

        $this->createRootPost->execute($story);

        return $story->refresh();
    }
}
