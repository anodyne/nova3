<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

class Link extends Button
{
    public function __construct(
        public string $href,
        public string $color = 'white',
        public string $size = 'md',
        public bool $fullWidth = false,
        public ?string $leading = null,
        public ?string $trailing = null
    ) {
        parent::__construct($color, $size, $fullWidth, $leading, $trailing);
    }

    public function render()
    {
        return view('components.link');
    }
}
