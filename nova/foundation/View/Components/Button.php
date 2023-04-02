<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $color = 'primary',
        public string $size = 'md',
        public bool $fullWidth = false,
        public ?string $leading = null,
        public ?string $trailing = null,
        public string $variant = 'filled',
    ) {
    }

    public function styles(): string
    {
        return Arr::toCssClasses([
            'group',
            'inline-flex items-center text-center justify-center rounded-md space-x-2 w-full md:w-auto',
            'font-medium',
            'transition ease-in-out duration-200',
            'focus:outline-none',
            'disabled:cursor-not-allowed disabled:opacity-75',
            'w-full md:w-auto' => $this->fullWidth,
            $this->colorStyles(),
            $this->variantStyles(),
            $this->sizeStyles(),
        ]);
    }

    public function colorStyles(): string
    {
        $style = "{$this->color}-{$this->variant}";

        return match ($style) {
            default => 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-200/10 hover:bg-gray-50 dark:hover:bg-gray-900/40 hover:border-gray-400/75 dark:hover:border-gray-200/20 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-gray-300 dark:focus:ring-gray-600',

            'dark-gray-text' => 'text-gray-600 hover:text-gray-700',
            'gray-text' => 'text-gray-500 hover:text-gray-600 dark:hover:text-gray-400',
            'light-gray-text' => 'text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400',

            'light-gray-primary-text' => 'text-gray-400 dark:text-gray-500 hover:text-primary-500 dark:hover:text-primary-500',
            'gray-primary-text' => 'text-gray-500 dark:text-gray-600 hover:text-primary-500 dark:hover:text-primary-500',

            'light-gray-danger-text' => 'text-gray-400 dark:text-gray-500 hover:text-danger-500 dark:hover:text-danger-500',
            'gray-danger-text' => 'text-gray-500 hover:text-danger-500 dark:hover:text-danger-500',

            'primary-filled' => 'border-transparent text-white bg-primary-500 hover:bg-primary-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-primary-200 dark:focus:ring-primary-900',
            'primary-outline' => 'border-primary-400 dark:border-primary-800 text-primary-500 dark:text-primary-300 hover:text-primary-600 hover:border-primary-500 dark:hover:text-primary-200 dark:hover:border-primary-700 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-primary-200 dark:focus:ring-primary-900',
            'primary-text' => 'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400',

            // 'info' => 'border-transparent text-white bg-info-500 hover:bg-info-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-info-200 dark:focus:ring-info-900',
            // 'info-outline' => 'bg-info-25 dark:bg-info-900 border-info-300 dark:border-info-800 text-info-600 dark:text-info-300 hover:bg-info-50 dark:hover:bg-info-900 hover:border-info-400 dark:hover:border-info-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-info-200 dark:focus:ring-info-900',
            // 'info-text' => 'text-info-500 hover:text-info-600 dark:hover:text-info-400',
            // 'info-text-bg' => 'border-transparent text-info-500 hover:text-info-600 hover:bg-info-50 dark:hover:bg-info-900 dark:hover:text-info-300',

            'danger-filled' => 'border-transparent text-white bg-danger-500 hover:bg-danger-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-danger-200 dark:focus:ring-danger-900',
            'danger-outline' => 'border-danger-400 dark:border-danger-800 text-danger-500 dark:text-danger-300 hover:text-danger-600 hover:border-danger-500 dark:hover:text-danger-200 dark:hover:border-danger-700 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-danger-200 dark:focus:ring-danger-900',
            'danger-text' => 'text-danger-500 hover:text-danger-600 dark:hover:text-danger-400',

            'warning' => 'border-transparent text-white bg-warning-500 hover:bg-warning-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-warning-200 dark:focus:ring-warning-900',
            'warning-outline' => 'bg-warning-25 dark:bg-warning-900 border-warning-300 dark:border-warning-800 text-warning-600 dark:text-warning-300 hover:bg-warning-50 dark:hover:bg-warning-900 hover:border-warning-400 dark:hover:border-warning-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-warning-200 dark:focus:ring-warning-900',
            'warning-text' => 'text-warning-500 hover:text-warning-600 dark:hover:text-warning-400',
            'warning-text-bg' => 'border-transparent text-warning-500 hover:text-warning-600 hover:bg-warning-50 dark:hover:bg-warning-900 dark:hover:text-warning-300',

            'gray' => 'border-transparent text-gray-600 bg-gray-300 hover:bg-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400',
        };
    }

    public function colorStylesOld(): string
    {
        $style = "{$this->color}-{$this->variant}";

        return match ($style) {
            default => 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-200/10 hover:bg-gray-50 dark:hover:bg-gray-900/40 hover:border-gray-400/75 dark:hover:border-gray-200/20 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-gray-300 dark:focus:ring-gray-600',

            'dark-gray-text' => 'text-gray-600 hover:text-gray-700',
            'gray-text' => 'text-gray-500 hover:text-gray-600 dark:hover:text-gray-400',
            'light-gray-text' => 'text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400',

            'light-gray-primary-text' => 'text-gray-400 dark:text-gray-500 hover:text-primary-500 dark:hover:text-primary-500',
            'gray-primary-text' => 'text-gray-500 dark:text-gray-600 hover:text-primary-500 dark:hover:text-primary-500',

            'light-gray-danger-text' => 'text-gray-400 dark:text-gray-500 hover:text-danger-500 dark:hover:text-danger-500',
            'gray-danger-text' => 'text-gray-500 hover:text-danger-500 dark:hover:text-danger-500',

            'primary' => 'border-transparent text-white bg-primary-500 hover:bg-primary-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-primary-200 dark:focus:ring-primary-900',
            'primary-outline' => 'bg-primary-25 dark:bg-primary-900 border-primary-300 dark:border-primary-800 text-primary-600 dark:text-primary-300 hover:bg-primary-50 dark:hover:bg-primary-900 hover:border-primary-400 dark:hover:border-primary-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-primary-200 dark:focus:ring-primary-900',
            'primary-text' => 'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400',
            'primary-text-bg' => 'border-transparent text-primary-500 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900 dark:hover:text-primary-300',

            'info' => 'border-transparent text-white bg-info-500 hover:bg-info-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-info-200 dark:focus:ring-info-900',
            'info-outline' => 'bg-info-25 dark:bg-info-900 border-info-300 dark:border-info-800 text-info-600 dark:text-info-300 hover:bg-info-50 dark:hover:bg-info-900 hover:border-info-400 dark:hover:border-info-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-info-200 dark:focus:ring-info-900',
            'info-text' => 'text-info-500 hover:text-info-600 dark:hover:text-info-400',
            'info-text-bg' => 'border-transparent text-info-500 hover:text-info-600 hover:bg-info-50 dark:hover:bg-info-900 dark:hover:text-info-300',

            'danger' => 'border-transparent text-white bg-danger-500 hover:bg-danger-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-danger-200 dark:focus:ring-danger-900',
            'danger-outline' => 'bg-danger-25 dark:bg-danger-900 border-danger-300 dark:border-danger-800 text-danger-600 dark:text-danger-200 hover:bg-danger-50 dark:hover:bg-danger-900 hover:border-danger-400 dark:hover:border-danger-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-danger-200 dark:focus:ring-danger-900',
            'danger-text' => 'text-danger-500 hover:text-danger-600 dark:hover:text-danger-400',
            'danger-text-bg' => 'border-transparent text-danger-500 hover:text-danger-600 hover:bg-danger-50 dark:hover:bg-danger-900 dark:hover:text-danger-200',

            'warning' => 'border-transparent text-white bg-warning-500 hover:bg-warning-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-warning-200 dark:focus:ring-warning-900',
            'warning-outline' => 'bg-warning-25 dark:bg-warning-900 border-warning-300 dark:border-warning-800 text-warning-600 dark:text-warning-300 hover:bg-warning-50 dark:hover:bg-warning-900 hover:border-warning-400 dark:hover:border-warning-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-warning-200 dark:focus:ring-warning-900',
            'warning-text' => 'text-warning-500 hover:text-warning-600 dark:hover:text-warning-400',
            'warning-text-bg' => 'border-transparent text-warning-500 hover:text-warning-600 hover:bg-warning-50 dark:hover:bg-warning-900 dark:hover:text-warning-300',

            'gray' => 'border-transparent text-gray-600 bg-gray-300 hover:bg-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400',
        };
    }

    public function variantStyles(): string
    {
        return match ($this->variant) {
            default => 'shadow-sm border',
            'outline' => 'shadow-sm border bg-transparent',
            'text' => 'underline',
        };
    }

    public function sizeStyles(): string
    {
        return match ($this->size) {
            'none' => 'text-base md:text-sm',
            'none-xs' => 'text-sm md:text-xs',
            'none-base' => 'text-base',
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
