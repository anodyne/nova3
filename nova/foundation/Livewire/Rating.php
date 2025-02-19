<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Component;
use Nova\Stories\Enums\ContentRatingValue;

class Rating extends Component
{
    #[Modelable]
    public ContentRatingValue $value = ContentRatingValue::Level0;

    public string $area = '';

    public function render()
    {
        return view('livewire.rating');
    }
}
