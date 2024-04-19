<?php

namespace Nova\Foundation\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Nova\Foundation\Colors\Color;
use Spatie\Color\Rgb;

class AdvancedColorPicker extends Component
{
    public ?string $color = null;

    public ?string $custom = null;

    public string $field = 'color';

    public ?string $shade = '500';

    #[Modelable]
    public ?string $state = null;

    #[Computed]
    public function colors(): array
    {
        return Color::all();
    }

    #[Computed]
    public function shades(): array
    {
        return [
            50,
            100,
            200,
            300,
            400,
            500,
            600,
            700,
            800,
            900,
            950
        ];
    }

    public function updated($property, $value): void
    {
        if ($property === 'color' || $property === 'shade') {
            $this->custom = null;
        }

        if ($property === 'custom') {
            $this->color = null;
            $this->shade = 500;
        }

        $this->setState();
    }

    public function render()
    {
        return view('livewire.advanced-color-picker', [
            'colors' => $this->colors,
            'shades' => $this->shades,
        ]);
    }

    protected function setState(): void
    {
        if (filled($this->custom)) {
            $this->state = $this->custom;
        }

        if (filled($this->color) && filled($this->shade)) {
            $this->state = Rgb::fromString(sprintf('rgb(%s)', $this->colors[$this->color][$this->shade]))->toHex();
        }
    }
}