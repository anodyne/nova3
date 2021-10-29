<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public string $placement = 'bottom-start',
        public bool $wide = false,
        public string $triggerColor = 'gray-text',
        public string $triggerSize = 'none',
        public string $id = 'options-menu'
    ) {
    }

    public function divider(): string
    {
        return 'border-t border-gray-3 my-1';
    }

    public function icon(): string
    {
        return 'mr-3 h-5 w-5 text-gray-7 group-hover:text-gray-8 group-focus:text-gray-8';
    }

    public function link(): string
    {
        return 'group flex items-center w-full px-4 py-2 text-sm font-medium text-gray-9 transition ease-in-out duration-200 hover:bg-gray-4 hover:text-gray-10 focus:outline-none';
    }

    public function text(): string
    {
        return 'block px-4 py-3 text-sm';
    }

    public function placementStyles(): string
    {
        return collect(explode(' ', $this->placement))
            ->map(function ($placement) {
                $string = Str::of($placement);

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
            'bottom-end' => ['right-0', 'left-auto','origin-top-right'],
            default => ['left-0', 'right-auto','origin-top-left'],
            'top-center' => ['left-0', 'right-auto','origin-bottom'],
            'top-end' => ['right-0', 'left-auto','origin-bottom-right'],
            'top-start' => ['left-0', 'right-auto','origin-bottom-left'],
        };

        $prefix = $breakpoint ? "{$breakpoint}:" : '';

        return collect($styles)
            ->map(fn ($style) => "{$prefix}{$style}")
            ->implode(' ');
    }
}
