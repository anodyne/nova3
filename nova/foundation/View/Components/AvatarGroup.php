<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class AvatarGroup extends Component
{
    public $size;

    public $items;

    public $limit;

    public function __construct($size = 'md', $items = null, $limit = 4)
    {
        $this->size = $size;
        $this->items = $items;
        $this->limit = $limit;
    }

    public function styles($index)
    {
        $startingZIndex = $this->limit * 10 - 10;
        $calculatedZIndex = $startingZIndex - $index * 10;
        $zIndex = ($index === 0) ? "z-{$startingZIndex}" : "-ml-2 z-{$calculatedZIndex}";

        return 'text-white shadow-solid ' . $zIndex;
    }

    public function render()
    {
        return view('components.avatar-group');
    }
}
