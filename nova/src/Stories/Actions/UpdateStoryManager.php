<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Media\Actions\UploadImage;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\UpdateStoryRequest;

class UpdateStoryManager
{
    use AsAction;

    public function handle(Story $story, UpdateStoryRequest $request): Story
    {
        return DB::transaction(function () use ($story, $request) {
            $story = UpdateStory::run($story, $request->getStoryData());

            SetStoryPosition::run($story, $request->getStoryPositionData());

            UpdateStoryStatus::run($story, $request->status);

            UploadImage::run(
                model: $story,
                collection: 'story-image',
                action: $request->getImageAction(),
                tempPath: $request->getImageTempPath(),
            );

            return $story->refresh();
        });
    }
}
