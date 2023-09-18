<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Component;

class ColorShadePicker extends Component
{
    public string $name = '';

    public string $type = '';

    public string $selected = '';

    public string $initial = '';

    public function updatedSelected($value): void
    {
        if (! array_key_exists($this->selected, $this->colors)) {
            if (! str_starts_with($this->selected, '#')) {
                $this->selected = '#'.$this->selected;
            }
        }
    }

    public function getPreviewColorProperty(): string
    {
        if (str_starts_with($this->selected, '#')) {
            return $this->selected;
        }

        if (filled($this->selected)) {
            return sprintf('rgb(%s)', constant('Nova\Foundation\Colors\Color::'.$this->selected)[500]);
        }

        return $this->selected;
    }

    public function getColorsProperty(): array
    {
        $grays = [
            'Slate' => 'Slate',
            'Gray' => 'Gray',
            'Zinc' => 'Zinc',
            'Neutral' => 'Neutral',
            'Stone' => 'Stone',
        ];

        $colors = [
            'Red' => 'Red',
            'RadicalRed' => 'Radical Red',
            'ImperialRed' => 'Imperial Red',
            'Orange' => 'Orange',
            'Amber' => 'Amber',
            'Yellow' => 'Yellow',
            'Lime' => 'Lime',
            'Green' => 'Green',
            'SeaGreen' => 'Sea Green',
            'Emerald' => 'Emerald',
            'Teal' => 'Teal',
            'Cyan' => 'Cyan',
            'Sky' => 'Sky',
            'Blue' => 'Blue',
            'Indigo' => 'Indigo',
            'Violet' => 'Violet',
            'Purple' => 'Purple',
            'Orchid' => 'Orchid',
            'Fuchsia' => 'Fuchsia',
            'Phlox' => 'Phlox',
            'Pink' => 'Pink',
            'Rose' => 'Rose',
        ];

        if ($this->type === 'gray') {
            return array_merge($grays, [
                '#' => 'Custom color',
            ]);
        }

        return array_merge(
            $colors,
            $grays,
            ['#' => 'Custom color']
        );
    }

    public function resetField(): void
    {
        if ($this->initial === $this->selected) {
            $this->selected = '';
        } else {
            $this->selected = $this->initial;
        }
    }

    public function mount($selected): void
    {
        $this->selected = $selected;
        $this->initial = $selected;
    }

    public function render()
    {
        return view('livewire.color-shade-picker', [
            'colors' => $this->colors,
        ]);
    }
}
