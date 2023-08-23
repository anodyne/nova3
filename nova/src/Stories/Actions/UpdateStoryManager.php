<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\UpdateStoryRequest;

class UpdateStoryManager
{
    use AsAction;

    public function handle(Story $story, UpdateStoryRequest $request): Story
    {
        $story = UpdateStory::run($story, $request->getStoryData());

        SetStoryPosition::run($story, $request->getStoryPositionData());

        UpdateStoryStatus::run($story, $request->status);

        UploadStoryImages::run($story, $request->image_path);

        return $story->refresh();
    }
}
