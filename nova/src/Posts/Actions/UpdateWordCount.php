<?php

namespace Nova\Posts\Actions;

use Nova\Posts\Models\Post;

class UpdateWordCount
{
    public function execute(Post $post): Post
    {
        return tap($post)->update([
            'word_count' => str_word_count($post->content),
        ]);
    }
}
