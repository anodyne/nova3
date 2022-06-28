<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Component;

class ColorShadePicker extends Component
{
    public string $name = '';

    public string $type = '';

    public string $selected = '';

    public function getColorsProperty(): array
    {
        if ($this->type === 'gray') {
            return [
                'gray' => 'Gray',
                'gray-blue' => 'Blue Gray',
                'gray-cool' => 'Cool Gray',
                'gray-iron' => 'Iron Gray',
                'gray-modern' => 'Modern Gray',
                'gray-neutral' => 'Neutral Gray',
                'gray-true' => 'True Gray',
                'gray-warm' => 'Warm Gray',
            ];
        }

        return [
            'amber' => 'Amber',
            'blue' => 'Blue',
            'blue-dark' => 'Dark Blue',
            'blue-light' => 'Light Blue',
            'cyan' => 'Cyan',
            'emerald' => 'Emerald',
            'fuchsia' => 'Fuchsia',
            'green' => 'Green',
            'green-light' => 'Light Green',
            'green-monster' => 'Green Monster',
            'indigo' => 'Indigo',
            'lilac' => 'Lilac',
            'moss' => 'Moss',
            'orange' => 'Orange',
            'international-orange' => 'International Orange',
            'pink' => 'Pink',
            'purple' => 'Purple',
            'red' => 'Red',
            'rose' => 'Rose',
            'teal' => 'Teal',
            'violet' => 'Violet',
            'yellow' => 'Yellow',
        ];
    }

    public function render()
    {
        return view('livewire.color-shade-picker', [
            'colors' => $this->colors,
        ]);
    }
}
