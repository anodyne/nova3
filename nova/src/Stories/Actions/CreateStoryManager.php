<?php

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;

class CreateStoryManager
{
    protected CreateStory $createStory;

    protected UpdateStoryStatus $updateStatus;

    protected UploadStoryImages $uploadImages;

    public function __construct(
        CreateStory $createStory,
        UpdateStoryStatus $updateStatus,
        UploadStoryImages $uploadImages
    ) {
        $this->createStory = $createStory;
        $this->updateStatus = $updateStatus;
        $this->uploadImages = $uploadImages;
    }

    public function execute(Request $request): Story
    {
        $story = $this->createStory->execute(
            $data = StoryData::fromRequest($request),
            $request
        );

        // $this->updateStatus->execute($story, $data);

        $this->uploadImages->execute($story, $request->images);

        return $story->refresh();
    }
}
