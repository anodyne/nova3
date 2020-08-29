<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $color;

    public $size;

    public function __construct($color = 'white', $size = 'md')
    {
        $this->color = $color;
        $this->size = $size;
    }

    public function baseStyles()
    {
        return 'inline-flex items-center border uppercase tracking-wide font-semibold rounded-md transition ease-in-out duration-150 focus:outline-none';
    }

    public function colorStyles()
    {
        switch ($this->color) {
            case 'white':
            default:
                return 'border-gray-300 text-gray-700 bg-white hover:text-gray-500 focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50';

                break;

            case 'blue':
                return 'border-transparent text-white bg-blue-600 hover:bg-blue-500 focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700';

                break;

            case 'soft-blue':
                return 'border-transparent text-blue-700 bg-blue-100 hover:bg-blue-50 focus:border-blue-300 focus:shadow-outline-blue active:bg-blue-200';

                break;

            case 'purple':
                return 'border-transparent text-white bg-purple-600 hover:bg-purple-500 focus:border-purple-700 focus:shadow-outline-purple active:bg-purple-700';

                break;
        }
    }

    public function sizeStyles()
    {
        switch ($this->size) {
            case 'xs':
                return 'px-2.5 py-1.5 text-xs';

                break;

            case 'sm':
                return 'px-3 py-2 text-sm';

                break;

            case 'md':
            default:
                return 'px-4 py-2 text-sm';

                break;

            case 'lg':
                return 'px-4 py-2 text-base';

                break;

            case 'xl':
                return 'px-6 py-3 text-base';

                break;
        }
    }

    public function render()
    {
        return view('components.button');
    }
}
