<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class UploadStoryImages
{
    use AsAction;

    public function handle(Story $story, $imagePath): Story
    {
        if ($imagePath !== null) {
            $story->addMedia($imagePath)->toMediaCollection('story-images');
        }

        return $story->refresh();
    }
}
