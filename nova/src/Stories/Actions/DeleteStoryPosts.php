<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class DeleteStoryPosts
{
    use AsAction;

    public function handle(Story $story): Story
    {
        $postIds = $story->allPosts()
            ->where('story_id', $story->id)
            ->pluck('id');

        if ($postIds->isNotEmpty()) {
            DB::table('post_author')
                ->whereIn('post_id', $postIds)
                ->delete();

            $story->allPosts()
                ->whereKey($postIds)
                ->delete();
        }

        return $story->refresh();
    }
}
