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
        $styles = 'inline-flex items-center text-center justify-center border rounded-md transition ease-in-out duration-150 focus:outline-none disabled:cursor-not-allowed disabled:opacity-75';

        if (! Str::endsWith($this->color, ['-text'])) {
            $styles .= ' uppercase tracking-wide font-semibold';
        }

        if (! Str::endsWith($this->color, ['-soft', '-text'])) {
            $styles .= ' shadow-sm';
        }

        if ($this->fullWidth) {
            $styles .= ' w-full justify-center';
        }

        return $styles;
    }

    public function colorStyles()
    {
        switch ($this->color) {
            case 'white':
            default:
                return 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-blue-7';

                break;

            case 'dark-gray-text':
                return 'border-transparent text-gray-600 font-medium hover:text-gray-800 focus:text-gray-800';

                break;

            case 'dark-gray-text':
                return 'border-transparent text-gray-600 font-medium hover:text-gray-800 focus:text-gray-800';

                break;

            case 'gray-text':
                return 'border-transparent font-medium text-gray-400 hover:text-gray-600';

                break;

            case 'blue':
                return 'border-transparent text-white bg-blue-9 hover:bg-blue-10 focus:ring-2 focus:ring-offset-2 focus:ring-blue-7';

                break;

            case 'blue-soft':
                return 'border-transparent text-blue-11 bg-blue-3 hover:bg-blue-4 focus:ring-2 focus:ring-offset-2 focus:ring-blue-7';

                break;

            case 'blue-text':
                return 'border-transparent font-medium text-blue-9 hover:text-blue-10';

                break;

            case 'purple':
                return 'border-transparent text-white bg-purple-9 hover:bg-purple-10 focus:ring-2 focus:ring-offset-2 focus:border-purple-6 focus:ring-purple-7';

                break;

            case 'purple-soft':
                return 'border-transparent text-purple-11 bg-purple-3 hover:bg-purple-4 focus:ring-2 focus:ring-offset-2 focus:ring-purple-7';

                break;

            case 'purple-text':
                return 'border-transparent font-medium text-purple-9 hover:text-purple-10';

                break;

            case 'red':
                return 'border-transparent text-white bg-red-9 hover:bg-red-10 focus:ring-2 focus:ring-offset-2 focus:ring-red-7';

                break;

            case 'red-soft':
                return 'border-transparent text-red-11 bg-red-3 hover:bg-red-4 focus:ring-2 focus:ring-offset-2 focus:ring-red-7';

                break;

            case 'red-text':
                return 'border-transparent font-medium text-red-9 hover:text-red-10';

                break;
        }
    }

    public function sizeStyles()
    {
        switch ($this->size) {
            case 'none':
                return 'text-sm';

                break;

            case 'none-xs':
                return 'text-xs';

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
