<?php

namespace Nova\Posts\Actions;

use Nova\Posts\Models\Post;
use Illuminate\Http\Request;

class CreatePostManager
{
    protected UpdateWordCount $updateWordCount;

    public function __construct(UpdateWordCount $updateWordCount)
    {
        $this->updateWordCount = $updateWordCount;
    }

    public function execute(Request $request): Post
    {
        $post = $this->createPost->execute(
            $data = PostData::fromRequest($request)
        );

        $post = $this->updateWordCount->execute($post);

        return $post->refresh();
    }
}
