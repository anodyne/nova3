<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Attributes\Locked;
use Nova\Foundation\Livewire\Modal;
use Nova\Stories\Models\Post;

class ReadPostModal extends Modal
{
    #[Locked]
    public int|Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('pages.posts.livewire.read-post-modal');
    }

    public static function size(): string
    {
        return '4xl';
    }
}
