<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class MoveStoryPosts
{
    use AsAction;

    public function handle(Story $oldStory, Story $newStory): Story
    {
        $oldStory->allPosts()->update(['story_id', $newStory->id]);

        return $newStory->refresh();
    }
}
