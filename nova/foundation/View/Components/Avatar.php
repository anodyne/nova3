<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class Avatar extends Component
{
    public string $src;

    public $size;

    public $tooltip;

    public function __construct($src = null, $size = 'md', $tooltip = '')
    {
        $this->src = $src;
        $this->size = $size;
        $this->tooltip = $tooltip;
    }

    public function styles()
    {
        switch ($this->size) {
            case 'xs':
                $size = 'h-8 w-8';

                break;

            case 'sm':
                $size = 'h-10 w-10';

                break;

            case 'md':
            default:
                $size = 'h-12 w-12';

                break;

            case 'lg':
                $size = 'h-14 w-14';

                break;

            case 'xl':
                $size = 'h-24 w-24';

                break;
        }

        return 'inline-block relative rounded-full ' . $size;
    }

    public function render()
    {
        return view('components.avatar');
    }
}
