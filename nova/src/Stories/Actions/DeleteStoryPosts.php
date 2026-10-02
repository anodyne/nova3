<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Story;

class DeleteStoryPosts extends Action
{
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
                ->forceDelete();
        }

        return $story->refresh();
    }
}
