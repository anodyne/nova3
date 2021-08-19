<?php

namespace Nova\Foundation\View\Components;

class Link extends Button
{
    public $href;

    public function __construct($href, $color = 'white', $size = 'md', $fullWidth = false)
    {
        parent::__construct($color, $size, $fullWidth);

        $this->href = $href;
    }

    public function render()
    {
        return view('components.link');
    }
}
