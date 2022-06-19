<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use LivewireUI\Modal\ModalComponent;

class SetContentRatingsModal extends ModalComponent
{
    public $language;

    public $sex;

    public $violence;

    protected $listeners = ['ratingUpdated'];

    public function apply(): void
    {
        $this->closeModalWithEvents([
            'posts:step:write-post' => ['contentRatingsUpdated', [
                $this->language, $this->sex, $this->violence,
            ]]
        ]);
    }

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function ratingUpdated(array $payload): void
    {
        [
            'rating' => $rating,
            'type' => $type
        ] = $payload;

        $this->{$type} = $rating;
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
