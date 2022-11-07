<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class ContentBox extends Component
{
    public function __construct(
        public string $height = 'base',
        public string $width = 'base',
    ) {
    }

    public function styles(): string
    {
        return Arr::toCssClasses([
            $this->heightStyles(),
            $this->widthStyles(),
        ]);
    }

    public function heightStyles(): string
    {
        return match ($this->height) {
            'none' => 'py-0',
            '2xs' => 'py-1.5',
            'xs' => 'py-3',
            'sm' => 'py-4',
            default => 'py-6',
        };
    }

    public function widthStyles(): string
    {
        return match ($this->width) {
            'none' => 'px-0',
            '2xs' => 'px-1.5',
            'xs' => 'px-3',
            'sm' => 'px-4',
            default => 'px-6',
        };
    }

    public function render()
    {
        return view('components.content-box');
    }
}
