<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $color = 'white',
        public string $size = 'md',
        public bool $fullWidth = false
    ) {
    }

    public function styles(): string
    {
        return Arr::toCssClasses([
            'inline-flex items-center text-center justify-center border rounded-md',
            'transition ease-in-out duration-150',
            'focus:outline-none',
            'disabled:cursor-not-allowed disabled:opacity-75',
            'uppercase tracking-wide font-semibold shadow-sm' => ! Str::endsWith($this->color, ['-text']),
            'font-medium border-transparent' => Str::endsWith($this->color, ['-text']),
            'w-full' => $this->fullWidth,
            $this->colorStyles(),
            $this->sizeStyles(),
        ]);
    }

    public function colorStyles(): string
    {
        return match ($this->color) {
            default => 'bg-gray-1 border-gray-7 text-gray-11 hover:bg-gray-2 hover:border-gray-8 focus:ring-2 focus:ring-offset-2 focus:ring-gray-7',

            'dark-gray-text' => 'text-gray-11 hover:text-gray-12',
            'gray-text' => 'text-gray-9 hover:text-gray-11',
            'light-gray-text' => 'text-gray-7 hover:text-gray-8',

            'blue' => 'border-transparent text-white bg-blue-9 hover:bg-blue-10 focus:ring-2 focus:ring-offset-2 focus:ring-blue-7',
            'blue-outline' => 'bg-blue-1 border-blue-7 text-blue-11 hover:bg-blue-2 hover:border-blue-8 focus:ring-2 focus:ring-offset-2 focus:ring-blue-7',
            'blue-text' => 'text-blue-9 hover:text-blue-10',

            'purple' => 'border-transparent text-white bg-purple-9 hover:bg-purple-10 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-1 focus:border-purple-6 focus:ring-purple-7',
            'purple-outline' => 'bg-purple-1 border-purple-7 text-purple-11 hover:bg-purple-2 hover:border-purple-8 focus:ring-2 focus:ring-offset-2 focus:ring-purple-7',
            'purple-text' => 'text-purple-9 hover:text-purple-10',

            'red' => 'border-transparent text-white bg-red-9 hover:bg-red-10 focus:ring-2 focus:ring-offset-2 focus:ring-red-7',
            'red-outline' => 'bg-red-1 border-red-7 text-red-11 hover:bg-red-2 hover:border-red-8 focus:ring-2 focus:ring-offset-2 focus:ring-red-7',
            'red-text' => 'text-red-9 hover:text-red-10',

            'gray' => 'border-transparent text-gray-11 bg-gray-6 hover:bg-gray-7 focus:ring-2 focus:ring-offset-2 focus:ring-gray-5',
        };
    }

    public function sizeStyles(): string
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
