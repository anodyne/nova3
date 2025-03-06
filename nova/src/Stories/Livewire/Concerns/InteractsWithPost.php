<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Nova\Stories\Models\Post;

trait InteractsWithPost
{
    public ?int $postId;

    public function getPost(): ?Post
    {
        return Post::findOrFail($this->postId);
    }
}
