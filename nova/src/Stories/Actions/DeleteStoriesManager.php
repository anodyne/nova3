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

            $actions = json_decode((string) $request->input('actions', '[]'), true);

            if (! is_array($actions)) {
                LogBatch::endBatch();

                return 0;
            }

            $stories = collect($actions);
            $sourceStoryIds = $stories->keys()
                ->map(fn ($id): int => (int) $id)
                ->filter();

            $targetStoryIds = $stories->flatMap(fn ($item): array => [
                (int) data_get($item, 'story.actionId'),
                (int) data_get($item, 'posts.actionId'),
            ])->filter();

            $storiesById = Story::query()
                ->whereKey($sourceStoryIds->merge($targetStoryIds)->unique()->values())
                ->get()
                ->keyBy('id');

            $resolveStory = static fn (mixed $id) => $storiesById->get((int) $id);
            $deletedStories = 0;

            $stories->where('story.action', 'move')->each(function ($item, $id) use ($resolveStory) {
                $story = $resolveStory($id);

                if (! $story) {
                    return;
                }

                $newParentId = data_get($item, 'story.actionId');
                $newParent = filled($newParentId) ? $resolveStory($newParentId) : null;

                if (filled($newParentId) && ! $newParent) {
                    return;
                }

                MoveStory::run(
                    $story,
                    $newParent
                );
            });

            $stories->where('posts.action', 'move')->each(function ($item, $id) use ($resolveStory) {
                $story = $resolveStory($id);
                $newStory = $resolveStory(data_get($item, 'posts.actionId'));

                if (! $story || ! $newStory) {
                    return;
                }

                MoveStoryPosts::run(
                    $story,
                    $newStory
                );
            });

            $stories->where('posts.action', 'delete')->each(function ($item, $id) use ($resolveStory) {
                $story = $resolveStory($id);

                if (! $story) {
                    return;
                }

                DeleteStoryPosts::run($story);
            });

            /**
             * Stories being deleted need to be reversed so the parent isn't deleted
             * first which will cascade delete all descendants.
             */
            $stories->where('story.action', 'delete')->reverse()->each(function ($item, $id) use (&$deletedStories, $resolveStory) {
                $story = $resolveStory($id);

                if (! $story) {
                    return;
                }

                DeleteStory::run($story);
                $deletedStories++;
            });

            LogBatch::endBatch();

            return $deletedStories;
        });
    }
}
