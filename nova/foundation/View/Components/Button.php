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
        return match ($this->color) {
            default => 'border-gray-7 text-gray-9 bg-gray-1 hover:bg-gray-2 hover:border-gray-8 hover:text-gray-10 focus:ring-2 focus:ring-offset-2 focus:ring-blue-7',

            'dark-gray-text' => 'border-transparent text-gray-11 font-medium hover:text-gray-12 focus:text-gray-12',
            'gray-text' => 'border-transparent text-gray-9 font-medium hover:text-gray-11 focus:text-gray-11',
            'light-gray-text' => 'border-transparent font-medium text-gray-7 hover:text-gray-8',

            'blue' => 'border-transparent text-white bg-blue-9 hover:bg-blue-10 focus:ring-2 focus:ring-offset-2 focus:ring-blue-7',
            'blue-soft' => 'border-transparent text-blue-11 bg-blue-3 hover:bg-blue-4 focus:ring-2 focus:ring-offset-2 focus:ring-blue-7',
            'blue-text' => 'border-transparent font-medium text-blue-9 hover:text-blue-10',

            'purple' => 'border-transparent text-white bg-purple-9 hover:bg-purple-10 focus:ring-2 focus:ring-offset-2 focus:border-purple-6 focus:ring-purple-7',
            'purple-soft' => 'border-transparent text-purple-11 bg-purple-3 hover:bg-purple-4 focus:ring-2 focus:ring-offset-2 focus:ring-purple-7',
            'purple-text' => 'border-transparent font-medium text-purple-9 hover:text-purple-10',

            'red' => 'border-transparent text-white bg-red-9 hover:bg-red-10 focus:ring-2 focus:ring-offset-2 focus:ring-red-7',
            'red-soft' => 'border-transparent text-red-11 bg-red-3 hover:bg-red-4 focus:ring-2 focus:ring-offset-2 focus:ring-red-7',
            'red-text' => 'border-transparent font-medium text-red-9 hover:text-red-10',
        };
    }

    public function sizeStyles()
    {
        return match ($this->size) {
            'none' => 'text-sm',
            'none-xs' => 'text-xs',
            'xs' => 'px-2.5 py-1.5 text-xs',
            'sm' => 'px-3 py-2 text-sm',
            'lg' => 'px-4 py-2 text-base',
            'xl' => 'px-6 py-3 text-lg',
            default => 'px-4 py-2 text-sm',
        };
    }

    public function render()
    {
        return view('components.button');
    }
}
