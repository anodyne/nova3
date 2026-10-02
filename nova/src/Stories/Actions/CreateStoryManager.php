<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Media\Actions\UploadImage;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\StoreStoryRequest;

class CreateStoryManager extends Action
{
    public function handle(StoreStoryRequest $request): Story
    {
        return DB::transaction(function () use ($request) {
            $story = CreateStory::run($request->getStoryData());

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
