<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $size;

    public $color;

    public $leadingIcon;

    public $trailingIcon;

    public function __construct($size = null, $color = null, $leadingIcon = null, $trailingIcon = null)
    {
        $this->size = $size;
        $this->color = $color;
        $this->leadingIcon = $leadingIcon;
        $this->trailingIcon = $trailingIcon;
    }

    public function baseStyles()
    {
        return 'inline-flex items-center rounded-full font-medium uppercase tracking-wide space-x-1 border';
    }

    public function colorStyles()
    {
        switch ($this->color) {
            case 'gray':
            default:
                return 'bg-gray-100 text-gray-800';

                break;

            case 'blue':
                return 'bg-blue-3 text-blue-11 border-blue-6';

                break;

            case 'green':
                return 'bg-green-3 text-green-11 border-green-6';

                break;

            case 'purple':
                return 'bg-purple-3 text-purple-11 border-purple-6';

                break;

            case 'red':
                return 'bg-red-3 text-red-11 border-red-6';

                break;

            case 'yellow':
                return 'bg-yellow-3 text-yellow-11';

                break;

            case 'dark-gray':
                return 'bg-gray-800 text-gray-100';

                break;
        }
    }

    public function iconStyles()
    {
        return "{$this->iconColorStyles()} {$this->iconSizeStyles()}";
    }

    public function iconColorStyles()
    {
        switch ($this->color) {
            case 'gray':
            default:
                return 'text-gray-600';

                break;

            case 'blue':
                return 'text-blue-9';

                break;

            case 'green':
                return 'text-green-9';

                break;

            case 'purple':
                return 'text-purple-9';

                break;

            case 'red':
                return 'text-red-9';

                break;

            case 'yellow':
                return 'text-yellow-9';

                break;
        }
    }

    public function iconSizeStyles()
    {
        switch ($this->size) {
            case 'xs':
                return 'h-4 w-4';

                break;

            default:
                return 'h-5 w-5';

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
