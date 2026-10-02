<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Story;

class DeleteStory extends Action
{
    public function handle(Story $story): Story
    {
        $story->stories()->update(['parent_id' => null]);

        return tap($story)->delete();
    }
}
