<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\StoreStoryRequest;

class CreateStoryManager
{
    use AsAction;

    public function handle(StoreStoryRequest $request): Story
    {
        $story = CreateStory::run($request->getStoryData());

        SetStoryPosition::run($story, $request->getStoryPositionData());

        UpdateStoryStatus::run($story, $request->status);

        UploadStoryImages::run($story, $request->image_path);

        return $story->refresh();
    }
}
