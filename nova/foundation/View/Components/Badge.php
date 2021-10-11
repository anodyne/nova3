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
            'inline-flex items-center rounded-full space-x-1.5',
            'font-medium uppercase tracking-wide border',
            $this->colorStyles(),
            $this->sizeStyles(),
        ]);
    }

    public function colorStyles(): string
    {
        return match ($this->color) {
            default => 'bg-gray-3 border-gray-6 text-gray-11',
            'blue' => 'bg-blue-3 border-blue-6 text-blue-11',
            'dark-gray' => 'bg-gray-11 text-gray-3',
            'green' => 'bg-green-3 border-green-6 text-green-11',
            'purple' => 'bg-purple-3 border-purple-6 text-purple-11',
            'red' => 'bg-red-3 border-red-6 text-red-11',
            'yellow' => 'bg-yellow-3 border-yellow-6 text-yellow-11',
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
            default => 'text-gray-9',
            'blue' => 'text-blue-9',
            'green' => 'text-green-9',
            'purple' => 'text-purple-9',
            'red' => 'text-red-9',
            'yellow' => 'text-yellow-9',
        };
    }

    public function iconSizeStyles(): string
    {
        return match ($this->size) {
            default => 'h-5 w-5',
            'xs' => 'h-4 w-4',
        };
    }

    public function sizeStyles(): string
    {
        return match ($this->size) {
            default => 'px-3 py-0.5 text-sm',
            'xs' => 'px-2.5 py-0.5 text-xs',
        };
    }

    public function render()
    {
        return view('components.badge');
    }
}
