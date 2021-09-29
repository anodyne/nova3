<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class ContentBox extends Component
{
    public function __construct(
        public bool $minHeight = false,
        public bool $noHeight = false,
        public bool $minWidth = false,
        public bool $noWidth = false,
    ) {
    }

    public function heightStyles()
    {
        return match (true) {
            $this->minHeight => 'py-2 sm:py-3',
            $this->noHeight => 'py-0',
            default => 'py-5 sm:py-6',
        };
    }

    public function widthStyles()
    {
        return match (true) {
            $this->minWidth => 'px-2 sm:px-3',
            $this->noWidth => 'px-0',
            default => 'px-4 sm:px-6',
        };
    }

    public function render()
    {
        return view('components.content-box');
    }
}
