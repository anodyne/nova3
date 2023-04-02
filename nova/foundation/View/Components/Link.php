<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

class Link extends Button
{
    public function __construct(
        public string $href,
        public string $color = 'primary',
        public string $size = 'md',
        public bool $fullWidth = false,
        public ?string $leading = null,
        public ?string $trailing = null,
        public string $variant = 'filled'
    ) {
        parent::__construct($color, $size, $fullWidth, $leading, $trailing, $variant);
    }

    public function render()
    {
        return view('components.link-old');
    }
}
