<?php

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;

class UpdateStoryManager
{
    protected SetStorySort $setStorySort;

    protected UpdateStory $updateStory;

    protected UpdateStoryStatus $updateStatus;

    protected UploadStoryImages $uploadImages;

    public function __construct(
        UpdateStory $updateStory,
        UpdateStoryStatus $updateStatus,
        UploadStoryImages $uploadImages,
        SetStorySort $setStorySort
    ) {
        $this->setStorySort = $setStorySort;
        $this->updateStory = $updateStory;
        $this->updateStatus = $updateStatus;
        $this->uploadImages = $uploadImages;
    }

    public function execute(Story $story, Request $request): Story
    {
        $story = $this->updateStory->execute(
            $story,
            $data = StoryData::fromRequest($request)
        );

        $this->setStorySort->execute($story, $data);

        // $this->updateStatus->execute($story, $request->status);

        // $this->uploadImages->execute($story, $request->image_path);

        return $story->refresh();
    }
}
