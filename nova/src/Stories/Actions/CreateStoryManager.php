<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Actions\CreateRootPost;
use Nova\Stories\DataTransferObjects\StoryData;
use Nova\Stories\DataTransferObjects\StoryPositionData;
use Nova\Stories\Models\Story;

class CreateStoryManager
{
    use AsAction;

    public function handle(Request $request): Story
    {
        $story = CreateStory::run(
            StoryData::fromRequest($request)
        );

        SetStoryPosition::run(
            $story,
            StoryPositionData::fromRequest($request)
        );

        UpdateStoryStatus::run($story, $request->status);

        UploadStoryImages::run($story, $request->image_path);

        CreateRootPost::run($story);

        return $story->refresh();
    }
}
