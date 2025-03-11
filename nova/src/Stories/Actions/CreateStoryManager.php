<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\StoreStoryRequest;
use Spatie\Activitylog\Facades\LogBatch;

class CreateStoryManager
{
    use AsAction;

    public function handle(StoreStoryRequest $request): Story
    {
        return DB::transaction(function () use ($request) {
            LogBatch::startBatch();

            $story = CreateStory::run($request->getStoryData());

            SetStoryPosition::run($story, $request->getStoryPositionData());

            UpdateStoryStatus::run($story, $request->status);

            UploadStoryImages::run($story, $request->image_path);

            LogBatch::endBatch();

            return $story->refresh();
        });
    }
}
