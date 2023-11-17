<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Rating extends Component
{
    #[Modelable]
    public int $value = 0;

    public string $area = '';

    // public function setRating(int $value): void
    // {
    //     if (! $this->static) {
    //         $this->value = $value;

    //         $this->dispatch(
    //             'ratingUpdated',
    //             rating: $this->rating,
    //             type: $this->type
    //         );
    //     }
    // }

    public function render()
    {
        return view('livewire.rating');
    }
}
