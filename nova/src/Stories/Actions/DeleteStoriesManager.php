<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;
use Spatie\Activitylog\Facades\LogBatch;

class DeleteStoriesManager
{
    use AsAction;

    public function handle(Request $request): int
    {
        return DB::transaction(function () use ($request) {
            LogBatch::startBatch();

            $stories = collect(json_decode($request->actions, true));

            $stories->where('story.action', 'move')->each(function ($item, $id) {
                MoveStory::run(
                    Story::find($id),
                    Story::find(data_get($item, 'story.actionId'))
                );
            });

            $stories->where('posts.action', 'move')->each(function ($item, $id) {
                MoveStoryPosts::run(
                    Story::find($id),
                    Story::find(data_get($item, 'posts.actionId'))
                );
            });

            $stories->where('posts.action', 'delete')->each(function ($item, $id) {
                DeleteStoryPosts::run(Story::find($id));
            });

            /**
             * Stories being deleted need to be reversed so the parent isn't deleted
             * first which will cascade delete all descendants.
             */
            $stories->where('story.action', 'delete')->reverse()->each(function ($item, $id) {
                DeleteStory::run(Story::find($id));
            });

            LogBatch::endBatch();

            return $stories->where('story.action', 'delete')->count();
        });
    }
}
