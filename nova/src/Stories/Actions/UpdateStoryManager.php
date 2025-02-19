<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\UpdateStoryRequest;
use Spatie\Activitylog\Facades\LogBatch;

class UpdateStoryManager
{
    use AsAction;

    public function handle(Story $story, UpdateStoryRequest $request): Story
    {
        return DB::transaction(function () use ($story, $request) {
            LogBatch::startBatch();

            $story = UpdateStory::run($story, $request->getStoryData());

            SetStoryPosition::run($story, $request->getStoryPositionData());

            UpdateStoryStatus::run($story, $request->status);

            UploadStoryImages::run($story, $request->image_path);

            LogBatch::endBatch();

            return $story->refresh();
        });
    }
}
