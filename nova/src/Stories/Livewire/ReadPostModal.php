<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use LivewireUI\Modal\ModalComponent;
use Nova\Stories\Models\Post;

class ReadPostModal extends ModalComponent
{
    public Post $post;

    /**
     * Dismiss the modal.
     */
    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('pages.posts.livewire.read-post-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
