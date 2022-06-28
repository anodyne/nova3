<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;

'field',
    'value' => false,
    'activeColor' => 'primary-500',
    'inactiveColor' => 'gray-400',
    'disabled' => false,
    'help' => false,
    'labelPosition' => 'after',

class Toggle extends Component
{
    public function __construct(
        public string $field,
        public string $value = false,
        public string $activeColor = 'primary-500',
        public string $inactiveColor = 'gray-400',
        public
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
            default => 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-200/10 hover:bg-gray-50 dark:hover:bg-gray-900/40 hover:border-gray-400/75 dark:hover:border-gray-200/20 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400',

            'dark-gray-text' => 'text-gray-600 hover:text-gray-700',
            'gray-text' => 'text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400',
            'light-gray-text' => 'text-gray-400 hover:text-gray-500',

            'gray-primary-text' => 'text-gray-500 hover:text-primary-600',
            'gray-error-text' => 'text-gray-500 hover:text-error-600',

            'primary' => 'border-transparent text-white bg-primary-500 hover:bg-primary-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-primary-400',
            'primary-outline' => 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-800 text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900 hover:border-primary-400 dark:hover:border-primary-600 focus:ring-2 focus:ring-offset-2 focus:ring-primary-400',
            'primary-text' => 'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400',

            'info' => 'border-transparent text-white bg-info-500 hover:bg-info-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-info-400',
            'info-outline' => 'bg-info-50 dark:bg-info-900 border-info-300 dark:border-info-800 text-info-600 dark:text-info-400 hover:bg-info-50 dark:hover:bg-info-900 hover:border-info-400 dark:hover:border-info-600 focus:ring-2 focus:ring-offset-2 focus:ring-info-400',
            'info-text' => 'text-info-500 hover:text-info-600 dark:hover:text-info-400',

            'error' => 'border-transparent text-white bg-error-500 hover:bg-error-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-error-400',
            'error-outline' => 'bg-error-50 dark:bg-error-900 border-error-300 dark:border-error-800 text-error-600 dark:text-error-400 hover:bg-error-50 dark:hover:bg-error-900 hover:border-error-400 dark:hover:border-error-600 focus:ring-2 focus:ring-offset-2 focus:ring-error-400',
            'error-text' => 'text-error-500 hover:text-error-600 dark:hover:text-error-400',

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
