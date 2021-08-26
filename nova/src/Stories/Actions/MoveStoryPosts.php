<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Posts\Actions\MovePost;
use Nova\Stories\Models\Story;

class MoveStoryPosts
{
    protected $movePost;

    public function __construct(MovePost $movePost)
    {
        $this->movePost = $movePost;
    }

    public function execute(Story $oldStory, Story $newStory): Story
    {
        $oldStory->posts->each(fn ($post) => $this->movePost->execute($post, $newStory));

        return $newStory->refresh();
    }
}
