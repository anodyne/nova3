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
            'font-medium uppercase tracking-wide border',
            $this->colorStyles(),
            $this->sizeStyles(),
            'rounded-full' => ! str($this->size)->contains('square'),
            'rounded-md' => str($this->size)->contains('square'),
        ]);
    }

    public function colorStyles(): string
    {
        return match ($this->color) {
            default => 'bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400',
            'blue' => 'bg-blue-50 dark:bg-blue-900/50 border-blue-300 dark:border-blue-700 text-blue-600 dark:text-blue-500',
            'green' => 'bg-green-50 dark:bg-green-900/30 border-green-300 dark:border-green-700 text-green-600 dark:text-green-500',
            'purple' => 'bg-purple-50 dark:bg-purple-900/30 border-purple-300 dark:border-purple-700 text-purple-600 dark:text-purple-500',
            'red' => 'bg-red-50 dark:bg-red-900/30 border-red-300 dark:border-red-700 text-red-600 dark:text-red-500',
            'yellow' => 'bg-yellow-50 dark:bg-yellow-900/50 border-yellow-300 dark:border-yellow-700 text-yellow-600 dark:text-yellow-500',
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
            'blue' => 'text-blue-500',
            'green' => 'text-green-500',
            'purple' => 'text-purple-500',
            'red' => 'text-red-500',
            'yellow' => 'text-yellow-500',
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
            default => 'px-4 py-1 text-base md:px-3 md:py-0.5 md:text-sm',
            'xs' => 'px-3 py-0.5 text-sm md:px-2.5 md:py-0.5 md:text-xs',
            'circle' => 'p-3',
            'circle-sm' => 'p-2',
            'circle-xs' => 'p-0.5',
            'square' => 'p-3',
            'square-sm' => 'p-2',
            'square-xs' => 'p-0.5',
        };
    }

    public function render()
    {
        return view('components.badge');
    }
}
