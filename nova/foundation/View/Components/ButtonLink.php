<?php

namespace Nova\Foundation\View\Components;

class ButtonLink extends Button
{
    public $href;

    public function __construct($href, $color = 'white', $size = 'md')
    {
        parent::__construct($color, $size);

        $this->href = $href;
    }

    public function render()
    {
        return view('components.button-link');
    }
}
