<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public string $size = 'md',
        public string $color = 'gray',
        public ?string $leadingIcon = null,
        public ?string $trailingIcon = null
    ) {
    }

    public function styles(): string
    {
        return Arr::toCssClasses([
            'inline-flex items-center space-x-1.5',
            'font-medium leading-normal',
            $this->colorStyles(),
            $this->sizeStyles(),
            'rounded-full' => ! str($this->size)->contains('square'),
            'rounded-md' => str($this->size)->contains('square'),
        ]);
    }

    public function colorStyles(): string
    {
        return match ($this->color) {
            default => 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-400',
            'primary' => 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-400',
            'success' => 'bg-success-100 dark:bg-success-900 text-success-700 dark:text-success-400',
            'info' => 'bg-info-100 dark:bg-info-900 text-info-700 dark:text-info-400',
            'error' => 'bg-error-100 dark:bg-error-900 text-error-700 dark:text-error-400',
            'warning' => 'bg-warning-100 dark:bg-warning-900 text-warning-700 dark:text-warning-400',
        };
    }

    public function iconStyles(): string
    {
        return Arr::toCssClasses([
            $this->iconColorStyles(),
            $this->iconSizeStyles(),
        ]);
    }

    public function iconColorStyles(): string
    {
        return match ($this->color) {
            default => 'text-gray-500',
            'primary' => 'text-primary-500',
            'success' => 'text-success-500',
            'info' => 'text-info-500',
            'error' => 'text-error-500',
            'warning' => 'text-warning-500',
        };
    }

    public function iconSizeStyles(): string
    {
        return match ($this->size) {
            default => 'h-6 w-6 md:h-5 md:w-5',
            'xs' => 'h-5 w-5 md:h-4 md:w-4',
        };
    }

    public function sizeStyles(): string
    {
        return match ($this->size) {
            default => 'px-3 py-0.5 text-sm',
            'xs' => 'px-2 py-0.5 text-xs',
            'lg' => 'px-4 py-1 text-base',

            'circle' => 'p-2',
            'circle-xs' => 'p-1',
            'circle-lg' => 'p-4',

            'square' => 'p-3',
            'square-xs' => 'p-1',
            'square-lg' => 'p-4',
        };
    }

    public function render()
    {
        return view('components.badge');
    }
}
