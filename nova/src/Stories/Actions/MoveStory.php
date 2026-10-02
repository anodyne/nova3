<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Story;

class MoveStory extends Action
{
    public function handle(Story $story, ?Story $newParent): Story
    {
        return tap($story)
            ->update(['parent_id' => $newParent?->id])
            ->refresh();
    }
}
