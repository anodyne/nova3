<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;

class MoveStory
{
    public function execute(Story $story, $newParent): Story
    {
        return tap($story)->update(['parent_id' => $newParent])->refresh();
    }
}
