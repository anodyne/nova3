<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;

class UploadStoryImages
{
    public function execute(Story $story, array $images = []): Story
    {
        if (count($images) > 0) {
            collect($images)->each(function ($image) use ($story) {
                $story->addMedia($image)->toMediaCollection('story-images');
            });
        }

        return $story->refresh();
    }
}
