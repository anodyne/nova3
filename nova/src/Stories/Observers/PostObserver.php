<?php

declare(strict_types=1);

namespace Nova\Stories\Observers;

use Nova\Stories\Models\Post;

class PostObserver
{
    public function saving(Post $post): void
    {
        $post->word_count = str($post->content)->pipe('strip_tags')->wordCount();
    }
}
