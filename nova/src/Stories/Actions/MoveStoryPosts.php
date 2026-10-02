<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Story;

class MoveStoryPosts extends Action
{
    public function handle(Story $oldStory, Story $newStory): Story
    {
        $oldStory->allPosts()->update(['story_id' => $newStory->id]);

        return $newStory->refresh();
    }
}
