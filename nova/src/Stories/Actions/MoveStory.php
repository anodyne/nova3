<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;

class MoveStory
{
    public function execute(Story $story, Story $newParent): Story
    {
        $newParent->appendNode($story);

        return $story->refresh();
    }
}
