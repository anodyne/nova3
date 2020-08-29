<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;

class UploadStoryImages
{
    public function execute(Story $story, $imagePath): Story
    {
        if ($imagePath !== null) {
            $story->addMedia($imagePath)->toMediaCollection('story-images');
        }

        return $story->refresh();
    }
}
