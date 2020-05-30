<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $size;

    public $type;

    public function __construct($size = null, $type = null)
    {
        $this->size = $size;
        $this->type = $type;
    }

    public function badgeSize()
    {
        return $this->size === null ?: 'badge-' . $this->size;
    }

    public function badgeType()
    {
        return $this->type === null ?: 'badge-' . $this->type;
    }

    public function render()
    {
        return view('components.badge');
    }
}
