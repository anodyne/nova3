<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;

class DeleteStory
{
    public function execute(Story $story): Story
    {
        return tap($story)->delete();
    }
}
