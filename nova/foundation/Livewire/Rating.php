<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Nova\Stories\Enums\ContentRatingValue;

class Rating extends Component
{
    #[Modelable]
    public ContentRatingValue $value = ContentRatingValue::Level0;

    public string $area = '';

    public function render(): Factory|View
    {
        return view('livewire.rating');
    }
}
