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
        return 'inline-flex items-center rounded-full font-medium uppercase tracking-wide space-x-1';
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
                return 'text-blue-600';

                break;

            case 'green':
                return 'text-green-600';

                break;

            case 'purple':
                return 'text-purple-600';

                break;

            case 'red':
                return 'text-red-600';

                break;

            case 'yellow':
                return 'text-yellow-600';

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
