<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Nova\Stories\Models\Post;

trait InteractsWithPost
{
    public ?string $postId;

    public function getPost(): ?Post
    {
        return once(fn () => Post::findOrFail($this->postId));
    }
}
