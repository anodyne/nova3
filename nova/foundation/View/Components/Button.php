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
            'group',
            'inline-flex items-center text-center justify-center border rounded-md',
            'transition ease-in-out duration-200',
            'focus:outline-none',
            'disabled:cursor-not-allowed disabled:opacity-75',
            'font-medium shadow-sm' => ! Str::endsWith($this->color, ['-text']),
            'font-medium border-transparent' => Str::endsWith($this->color, ['-text']),
            'w-full' => $this->fullWidth,
            $this->colorStyles(),
            $this->sizeStyles(),
        ]);
    }

    public function colorStyles(): string
    {
        return match ($this->color) {
            default => 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-200/10 hover:bg-gray-50 dark:hover:bg-gray-900/40 hover:border-gray-400/75 dark:hover:border-gray-200/20 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-gray-300 dark:focus:ring-gray-600',

            'dark-gray-text' => 'text-gray-600 hover:text-gray-700',
            'gray-text' => 'text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400',
            'light-gray-text' => 'text-gray-400 hover:text-gray-500',

            'gray-blue-text' => 'text-gray-400 dark:text-gray-500 hover:text-blue-500 dark:hover:text-blue-500',
            'gray-red-text' => 'text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-500',

            'blue' => 'border-transparent text-white bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-blue-300 dark:focus:ring-blue-800',
            'blue-outline' => 'bg-blue-25 dark:bg-blue-900 border-blue-300 dark:border-blue-800 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 hover:border-blue-400 dark:hover:border-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-blue-300 dark:focus:ring-blue-800',
            'blue-text' => 'text-blue-500 hover:text-blue-600 dark:hover:text-blue-400',

            'purple' => 'border-transparent text-white bg-purple-500 hover:bg-purple-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-purple-300 dark:focus:ring-purple-800',
            'purple-outline' => 'bg-purple-25 dark:bg-purple-900 border-purple-300 dark:border-purple-800 text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900 hover:border-purple-400 dark:hover:border-purple-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-purple-300 dark:focus:ring-purple-800',
            'purple-text' => 'text-purple-500 hover:text-purple-600 dark:hover:text-purple-400',

            'red' => 'border-transparent text-white bg-red-500 hover:bg-red-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-red-300 dark:focus:ring-red-800',
            'red-outline' => 'bg-red-50 dark:bg-red-900 border-red-300 dark:border-red-800 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 hover:border-red-400 dark:hover:border-red-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-red-300 dark:focus:ring-red-800',
            'red-text' => 'text-red-500 hover:text-red-600 dark:hover:text-red-400',

            'gray' => 'border-transparent text-gray-600 bg-gray-300 hover:bg-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400',
        };
    }

    public function sizeStyles(): string
    {
        return match ($this->size) {
            'none' => 'text-base md:text-sm',
            'none-xs' => 'text-sm md:text-xs',
            'xs' => 'px-3 py-2 text-sm md:px-2.5 md:py-1.5 md:text-xs',
            'sm' => 'px-4 py-2 text-base md:px-3 md:py-2 md:text-sm',
            default => 'px-4 py-3 md:py-2 text-base md:text-sm',
        };
    }

    public function render()
    {
        return view('components.button');
    }
}
