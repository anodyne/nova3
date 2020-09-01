<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $size;

    public $color;

    public function __construct($size = null, $color = null)
    {
        $this->size = $size;
        $this->color = $color;
    }

    public function baseStyles()
    {
        return 'inline-flex items-center rounded-full font-medium uppercase tracking-wide';
    }

    public function colorStyles()
    {
        switch ($this->color) {
            case 'gray':
            default:
                return 'bg-gray-200 text-gray-800';

                break;

            case 'blue':
                return 'bg-blue-100 text-blue-800';

                break;

            case 'green':
                return 'bg-green-100 text-green-800';

                break;

            case 'purple':
                return 'bg-purple-100 text-purple-800';

                break;

            case 'red':
                return 'bg-red-100 text-red-800';

                break;

            case 'yellow':
                return 'bg-yellow-100 text-yellow-800';

                break;
        }
    }

    public function sizeStyles()
    {
        switch ($this->size) {
            case 'xs':
                return 'px-2.5 py-0.5 text-xs';

                break;

            default:
                return 'px-3 py-0.5 text-sm';

                break;
        }
    }

    public function render()
    {
        return view('components.badge');
    }
}
