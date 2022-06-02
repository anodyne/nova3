<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use LivewireUI\Modal\ModalComponent;

class SetContentRatingsModal extends ModalComponent
{
    /**
     * Apply the the selected day to the post.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'posts:step:write-post' => ['contentRatingsSet'],
        ]);
    }

    /**
     * Dismiss the modal.
     */
    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function render()
    {
        return view('livewire.posts.set-content-ratings-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
