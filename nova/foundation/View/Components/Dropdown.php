<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public string $placement = 'bottom-start',
        public bool $wide = false,
        public string $id = 'options-menu',
        public ?string $maxHeight = null
    ) {
    }

    public function placementStyles(): string
    {
        return collect(explode(' ', $this->placement))
            ->map(function ($placement) {
                $string = str($placement);

                if ($string->contains(':')) {
                    return $this->placement($string->after(':'), $string->before(':'));
                }

                return $this->placement($string, '');
            })
            ->implode(' ');
    }

    public function render()
    {
        return view('components.dropdown.index');
    }

    protected function placement($placement, $breakpoint): string
    {
        $styles = match ((string) $placement) {
            'bottom-center' => ['left-0', 'right-auto', 'origin-top'],
            'bottom-end' => ['right-0', 'left-auto', 'origin-top-right'],
            default => ['left-0', 'right-auto', 'origin-top-left'],
            'top-center' => ['left-0', 'right-auto', 'origin-bottom'],
            'top-end' => ['right-0', 'left-auto', 'origin-bottom-right'],
            'top-start' => ['left-0', 'right-auto', 'origin-bottom-left'],
        };

        $prefix = $breakpoint ? "{$breakpoint}:" : '';

        return collect($styles)
            ->map(fn ($style) => "{$prefix}{$style}")
            ->implode(' ');
    }
}
