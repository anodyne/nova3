<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Data\StoryPositionData;
use Nova\Stories\Models\Story;

class UpdateStoryManager
{
    use AsAction;

    public function handle(Story $story, Request $request): Story
    {
        $story = UpdateStory::run($story, StoryData::from($request));

        SetStoryPosition::run($story, StoryPositionData::from($request));

        UpdateStoryStatus::run($story, $request->status);

        UploadStoryImages::run($story, $request->image_path);

        return $story->refresh();
    }
}
