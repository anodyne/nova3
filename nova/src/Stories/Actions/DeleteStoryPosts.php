<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class DeleteStoryPosts
{
    use AsAction;

    public function handle(Story $story): Story
    {
        $story->allPosts()->where('story_id', $story->id)->delete();

        return $story->refresh();
    }
}
