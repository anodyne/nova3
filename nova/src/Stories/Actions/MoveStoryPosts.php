<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Actions\MovePost;
use Nova\Stories\Models\Story;

class MoveStoryPosts
{
    use AsAction;

    public function handle(Story $oldStory, Story $newStory): Story
    {
        $oldStory->posts->each(fn ($post) => MovePost::run($post, $newStory));

        return $newStory->refresh();
    }
}
