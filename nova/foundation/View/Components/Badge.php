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
        public ?string $trailingIcon = null,
        public bool $icon = false,
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
            $this->iconSizeStyles() => $this->icon,
            $this->iconStyles() => $this->icon,
        ]);
    }

    public function colorStyles(): string
    {
        return match ($this->color) {
            default => 'bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400',
            'primary' => 'bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400',
            'success' => 'bg-success-100 dark:bg-success-900 text-success-600 dark:text-success-400',
            'info' => 'bg-info-100 dark:bg-info-900 text-info-600 dark:text-info-400',
            'danger' => 'bg-danger-100 dark:bg-danger-900 text-danger-600 dark:text-danger-400',
            'warning' => 'bg-warning-100 dark:bg-warning-900 text-warning-600 dark:text-warning-400',
        };
    }

    public function iconStyles(): string
    {
        return match ($this->color) {
            default => 'ring-gray-50 dark:ring-gray-900/50',
            'primary' => 'ring-primary-50 dark:ring-primary-900/50',
            'success' => 'ring-success-50 dark:ring-success-900/50',
            'info' => 'ring-info-50 dark:ring-info-900/50',
            'danger' => 'ring-danger-50 dark:ring-danger-900/50',
            'warning' => 'ring-warning-50 dark:ring-warning-900/50',
        };
    }

    public function iconSizeStyles(): string
    {
        return match ($this->size) {
            default => 'ring-4',
            'circle', 'square' => 'ring-[6px]',
            'circle', 'circle-lg', 'square', 'square-lg' => 'ring-8',
        };
    }

    // public function iconStyles(): string
    // {
    //     return Arr::toCssClasses([
    //         $this->iconColorStyles(),
    //         $this->iconSizeStyles(),
    //     ]);
    // }

    // public function iconColorStyles(): string
    // {
    //     return match ($this->color) {
    //         default => 'text-gray-500',
    //         'primary' => 'text-primary-500',
    //         'success' => 'text-success-500',
    //         'info' => 'text-info-500',
    //         'danger' => 'text-danger-500',
    //         'warning' => 'text-warning-500',
    //     };
    // }

    // public function iconSizeStyles(): string
    // {
    //     return match ($this->size) {
    //         default => 'h-6 w-6 md:h-5 md:w-5',
    //         'xs' => 'h-5 w-5 md:h-4 md:w-4',
    //     };
    // }

    public function sizeStyles(): string
    {
        return match ($this->size) {
            default => 'px-3 py-0.5 text-sm',
            'xs' => 'px-2 py-0.5 text-xs',
            'lg' => 'px-4 py-1 text-base',

            'circle-xs' => 'p-1',
            'circle-sm' => 'p-1.5',
            'circle' => 'p-2',
            'circle-lg' => 'p-4',

            'square-xs' => 'p-1',
            'square-sm' => 'p-1.5',
            'square' => 'p-2',
            'square-lg' => 'p-4',
        };
    }

    public function render()
    {
        return view('components.badge');
    }
}
