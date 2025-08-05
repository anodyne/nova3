<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Icons\Icon;

class IconPicker extends Component
{
    public string $field = 'icon';

    public ?string $selected = '';

    public function render()
    {
        return view('livewire.icon-picker', [
            'iconObject' => $this->iconObject,
        ]);
    }

    #[Computed]
    public function iconObject(): ?Icon
    {
        return Icon::tryFrom($this->selected);
    }
}
