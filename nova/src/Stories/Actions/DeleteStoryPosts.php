<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;
use Nova\Posts\Actions\DeletePost;

class DeleteStoryPosts
{
    protected $deletePost;

    public function __construct(DeletePost $deletePost)
    {
        $this->deletePost = $deletePost;
    }

    public function execute(Story $story): Story
    {
        $story->posts->each(fn ($post) => $this->deletePost->execute($post));

        return $story->refresh();
    }
}
