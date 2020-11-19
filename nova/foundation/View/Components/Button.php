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
        $styles = 'inline-flex items-center border rounded-md transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2';

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
                return 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-blue-500';

                break;

            case 'gray-text':
                return 'border-transparent font-medium text-gray-400 hover:text-gray-600 focus:ring-blue-500';

                break;

            case 'blue':
                return 'border-transparent text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500';

                break;

            case 'blue-soft':
                return 'border-transparent text-blue-700 bg-blue-100 hover:bg-blue-200 focus:ring-blue-500';

                break;

            case 'blue-text':
                return 'border-transparent font-medium text-blue-600 hover:text-blue-800 focus:ring-blue-500';

                break;

            case 'purple':
                return 'border-transparent text-white bg-purple-600 hover:bg-purple-700 focus:border-purple-700 focus:ring-purple-500';

                break;

            case 'purple-soft':
                return 'border-transparent text-purple-700 bg-purple-100 hover:bg-purple-200 focus:ring-purple-500';

                break;

            case 'purple-text':
                return 'border-transparent font-medium text-purple-600 hover:text-purple-800 focus:ring-purple-500';

                break;

            case 'red':
                return 'border-transparent text-white bg-red-600 hover:bg-red-700 focus:border-red-700 focus:ring-red-500';

                break;

            case 'red-soft':
                return 'border-transparent text-red-700 bg-red-100 hover:bg-red-200 focus:ring-red-500';

                break;

            case 'red-text':
                return 'border-transparent font-medium text-red-600 hover:text-red-800 focus:ring-red-500';

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
