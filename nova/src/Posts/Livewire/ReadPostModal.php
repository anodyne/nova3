<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use LivewireUI\Modal\ModalComponent;
use Nova\Posts\Models\Post;

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
        return view('livewire.posts.read-post-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
