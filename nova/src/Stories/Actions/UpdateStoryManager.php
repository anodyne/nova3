<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\DataTransferObjects\StoryData;
use Nova\Stories\DataTransferObjects\StoryPositionData;
use Nova\Stories\Models\Story;

class UpdateStoryManager
{
    use AsAction;

    public function handle(Story $story, Request $request): Story
    {
        $story = UpdateStory::run(
            $story,
            StoryData::fromRequest($request)
        );

        SetStoryPosition::run(
            $story,
            StoryPositionData::fromRequest($request)
        );

        UpdateStoryStatus::run($story, $request->status);

        UploadStoryImages::run($story, $request->image_path);

        return $story->refresh();
    }
}
