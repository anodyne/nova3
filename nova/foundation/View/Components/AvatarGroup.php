<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class AvatarGroup extends Component
{
    public function __construct(
        public $size = 'md',
        public $items = null,
        public $limit = 4
    ) {
        $this->size = $size;
        $this->items = $items;
        $this->limit = $limit;
    }

    public function styles()
    {
        return 'ring-2 ring-white dark:ring-gray-800';
    }

    public function render()
    {
        return view('components.avatar.group');
    }
}
