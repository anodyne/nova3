<?php

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Button extends Component
{
    public $color;

    public $fullWidth;

    public $size;

    public function __construct($color = 'white', $size = 'md', $fullWidth = false)
    {
        $this->color = $color;
        $this->fullWidth = $fullWidth;
        $this->size = $size;
    }

    public function baseStyles()
    {
        $styles = 'inline-flex items-center border rounded-md transition ease-in-out duration-150 focus:outline-none';

        if (! Str::startsWith($this->color, ['text-'])) {
            $styles .= ' uppercase tracking-wide font-semibold';
        }

        if ($this->fullWidth) {
            $styles .= ' w-full justify-center';
        }

        return $styles;
    }

    public function containerStyles()
    {
        $styles = 'inline-flex rounded-md';

        if (! Str::startsWith($this->color, ['soft-', 'text-'])) {
            $styles .= ' shadow-sm';
        }

        if ($this->fullWidth) {
            $styles .= ' w-full';
        }

        return $styles;
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

            case 'text-purple':
                return 'border-transparent text-purple-600 font-medium hover:text-purple-800';

                break;

            case 'red':
                return 'border-transparent text-white bg-red-600 hover:bg-red-500 focus:border-red-700 focus:shadow-outline-red active:bg-red-700';

                break;

            case 'soft-red':
                return 'border-transparent text-red-700 bg-red-100 hover:bg-red-50 focus:border-red-300 focus:shadow-outline-red active:bg-red-200';

                break;
        }
    }

    public function sizeStyles()
    {
        switch ($this->size) {
            case 'none':
                return 'text-sm';

                break;

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
