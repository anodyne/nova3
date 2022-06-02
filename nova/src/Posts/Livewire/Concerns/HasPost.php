<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Models\Post;

trait HasPost
{
    public $postId;

    public mixed $post;

    public function mountWritesPost()
    {
        $this->post = Post::firstOrNew(['id' => $this->postId]);
    }
}
