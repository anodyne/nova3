<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class ContentBox extends Component
{
    public function __construct(
        public string $height = 'base',
        public string $width = 'base',
    ) {
    }

    public function heightStyles(): string
    {
        return match ($this->height) {
            'none' => 'py-0',
            'xs' => 'py-2 sm:py-3',
            'sm' => 'py-3 sm:py-4',
            default => 'py-5 sm:py-6',
        };
    }

    public function widthStyles(): string
    {
        return match ($this->width) {
            'none' => 'px-0',
            'xs' => 'px-2 sm:px-3',
            'sm' => 'px-3 sm:px-4',
            default => 'px-4 sm:px-6',
        };
    }

    public function render()
    {
        return view('components.content-box');
    }
}
