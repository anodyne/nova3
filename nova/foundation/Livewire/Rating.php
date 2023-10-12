<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Component;

class Rating extends Component
{
    public int $rating = 0;

    public string $type = '';

    public bool $static = false;

    public function setRating(int $value): void
    {
        if (! $this->static) {
            $this->rating = $value;

            $this->dispatch(
                'ratingUpdated',
                rating: $this->rating,
                type: $this->type
            );
        }
    }

    public function render()
    {
        return view('livewire.rating');
    }
}
