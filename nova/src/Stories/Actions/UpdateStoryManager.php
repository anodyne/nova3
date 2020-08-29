<?php

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\DataTransferObjects\StoryData;

class UpdateStoryManager
{
    protected UpdateStory $updateStory;

    protected UpdateStoryStatus $updateStatus;

    protected UploadStoryImages $uploadImages;

    public function __construct(
        UpdateStory $updateStory,
        UpdateStoryStatus $updateStatus,
        UploadStoryImages $uploadImages
    ) {
        $this->updateStory = $updateStory;
        $this->updateStatus = $updateStatus;
        $this->uploadImages = $uploadImages;
    }

    public function execute(Story $story, Request $request): Story
    {
        // dd($request->all());
        $story = $this->updateStory->execute(
            $story,
            $data = StoryData::fromRequest($request)
        );

        // $this->updateStatus->execute($story, $request->status);

        // $this->uploadImages->execute($story, $request->image_path);

        Story::rebuildTree([]);

        return $story->refresh();
    }
}
