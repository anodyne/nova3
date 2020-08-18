<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;

class UpdateStory
{
    public function execute(Story $story): Story
    {
        return tap($story)->update($data->toArray());
    }
}
