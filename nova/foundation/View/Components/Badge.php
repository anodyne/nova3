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
            'inline-flex items-center font-medium leading-normal no-underline ring-1 ring-inset',
            'rounded-lg' => ! str($this->size)->contains('circle'),
            'rounded-full' => str($this->size)->contains('circle'),
            $this->colorStyles(),
            $this->sizeStyles(),
            // $this->iconSizeStyles() => $this->icon,
            // $this->iconStyles() => $this->icon,
        ]);
    }

    public function colorStyles(): string
    {
        return match ($this->color) {
            default => 'bg-gray-50 dark:bg-gray-400/10 text-gray-600 dark:text-gray-400 ring-gray-500/10 dark:ring-gray-400/20',
            'primary' => 'bg-primary-50 dark:bg-primary-400/10 text-primary-600 dark:text-primary-400 ring-primary-500/10 dark:ring-primary-400/20',
            'success' => 'bg-success-50 dark:bg-success-400/10 text-success-600 dark:text-success-400 ring-success-500/10 dark:ring-success-400/20',
            'secondary' => 'bg-secondary-50 dark:bg-secondary-400/10 text-secondary-600 dark:text-secondary-400 ring-secondary-500/10 dark:ring-secondary-400/20',
            'danger' => 'bg-danger-50 dark:bg-danger-400/10 text-danger-600 dark:text-danger-400 ring-danger-500/10 dark:ring-danger-400/20',
            'warning' => 'bg-warning-50 dark:bg-warning-400/10 text-warning-600 dark:text-warning-400 ring-warning-500/10 dark:ring-warning-400/20',
        };
    }

    public function iconStyles(): string
    {
        return match ($this->color) {
            default => 'ring-gray-50 dark:ring-gray-900/50',
            'primary' => 'ring-primary-50 dark:ring-primary-900/50',
            'success' => 'ring-success-50 dark:ring-success-900/50',
            'secondary' => 'ring-secondary-50 dark:ring-secondary-900/50',
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
    //         'secondary' => 'text-secondary-500',
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
            default => 'px-2 py-1 text-xs',
            'xs' => 'px-2 py-1 text-xs',
            'lg' => 'px-2 py-1 text-xs',

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
