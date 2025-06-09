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
        if (is_null($imagePath)) {
            $story->clearMediaCollection('story-image');

            activity()
                ->performedOn($story)
                ->event('removed story image')
                ->log('removed story image');
        } else {
            $story->addMedia($imagePath)->toMediaCollection('story-image');

            activity()
                ->performedOn($story)
                ->event('uploaded story image')
                ->log('uploaded story image');
        }

        return $story->refresh();
    }
}
